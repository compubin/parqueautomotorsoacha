<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class IpblockedMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = config('sximo');
        if($config['cnf_allowip'] !='')
        { 
            $ipsAllow = explode(',',preg_replace('/\s+/', '', $config['cnf_allowip']));
            if(count($ipsAllow) >= 1 )
            {
                if(!in_array($request->ip(), $ipsAllow))
                {
                    return redirect('restric');
                }
            }
         }   


        $ips = explode(',',preg_replace('/\s+/', '', $config['cnf_restrictip']));
        if(is_array($ips))
        {
            if(in_array($request->ip(), $ips))
            {
                return redirect('restric');
            }
        }

        if(!\Session::has('lang'))
        {
            \Session::put('lang',config('sximo.cnf_lang'));
        }

        app()->setLocale(\Session::get('lang'));
        if(\Auth::check())
        {
            $sql = \DB::table('tb_groups')->where('group_id' ,Auth::user()->group_id )->get();
            $level = 99;
            if(count($sql))
            {
                $l = $sql[0];
                $level = $l->level ;
            }

            if(!\Session::has('uid'))
            {
                $session = array(
                    'gid'       => Auth::user()->group_id,
                    'uid'       => Auth::user()->id,
                    'eid'       => Auth::user()->email,
                    'll'        => Auth::user()->last_login,
                    'fid'       =>  Auth::user()->first_name.' '. Auth::user()->last_name,
                    'username'  =>  Auth::user()->username ,
                    'join'      =>  Auth::user()->created_at,
                    'level'     => $level
                );              
                session($session);                
            }
        }   

        if($request->session()->get('uid') !='')
        {
            $data = array( 'last_activity' => strtotime(date("y-m-d H:i:s")) );
            \DB::table('tb_users')->where('id', $request->session()->get('uid') )->update($data);
        }         

        return $next($request);
    }
}
