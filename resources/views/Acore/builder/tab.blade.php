<ul class="nav nav-tabs" style="margin-bottom:30px;">
    <li><a href="{{ url('builder')}}"> All </a></li>
    <li @if($active == 'config') class="active" @endif ><a href="{{ URL::to('builder/config/'.$module_name)}}"> Info</a></li>

    @if(Auth::user()->email == 'cc.cruz.caceres@gmail.com')
        <li @if($active == 'sql') class="active" @endif >
            @if(isset($type) && $type =='blank')

            @else
                <a href="{{ URL::to('builder/sql/'.$module_name)}}"> SQL</a></li>

        <li @if($active == 'table') class="active" @endif >
            <a href="{{ URL::to('builder/table/'.$module_name)}}"> Table</a></li>
        <li @if($active == 'form' or $active == 'subform') class="active" @endif >
            <a href="{{ URL::to('builder/form/'.$module_name)}}"> Form</a></li>
    @endif
<!--<li @if($active == 'sub'  ) class="active" @endif >
  <a href="{{ URL::to('builder/sub/'.$module_name)}}"> Master Detail</a></li>-->
    @endif
    <li @if($active == 'permission') class="active" @endif >
        <a href="{{ URL::to('builder/permission/'.$module_name)}}"> Permission</a></li>
    @if(Auth::user()->email == 'cc.cruz.caceres@gmail.com')
        <li @if($active == 'template') class="active" @endif >
            <a href="{{ URL::to('builder/template/'.$module_name)}}"> Template </a></li>
@endif

<!--<li @if($active == 'rebuild') class="active" @endif >
    <a href="javascript://ajax" onclick="SximoModal('{{ URL::to('builder/build/'.$module_name)}}','Rebuild Module ')"> Rebuild</a></li>-->

    <li class="dropdown pull-right">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Swith</a>
        <ul class="dropdown-menu">
            <?php $md = DB::table('tb_module')->where('module_type','!=','core')->get();
            foreach($md as $m) { ?>
            <li><a href="{{ url('builder/'.$active.'/'.$m->module_name)}}"> {{ $m->module_title}}</a></li>
            <?php } ?>
        </ul>
    </li>



</ul>