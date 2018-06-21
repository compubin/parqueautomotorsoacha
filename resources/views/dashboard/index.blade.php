@extends('layouts.app')


@section('content')
<div class="page-content row"> 
<div class="page-content-wrapper m-t clearfix">

    <div class="sbox m-t bg-gray">
        <div class="sbox-title" style="padding: 5px 0;"> <h5> My Dashboard  <small>  </small></h5>
             <div class="sbox-tools">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="font-extra-bold font-uppercase"> <i class="fa fa-bars"></i> Manage My Widgets </span>
                    </a>
                    <ul class="dropdown-menu animated pull-right mywidget-form" style="display: none">
                         @foreach($widgets as $widget)
                            <li><a href="javascript://ajax">
                                <input type="checkbox" name="widget[]" value="{{ $widget->widget_id}}" class="minimal-green" class=""
                                @if(in_array($widget->widget_id , $selected_widget)) checked @endif
                                 />  {{ $widget->name }}</a>
                            </li>
                         @endforeach
                         <li class="divider"></li>
                         <li style="text-align: center !important;"><a href="javascript://ajax" class="btn  btn-sm set_widget"> Save change(s) </a></li>
                    </ul>
                 </div>   
            </div>
        </div>
        <div class="sbox-content" style="padding: 10px 0;">

            <div class="row">
            @if(count($selected_widget))   
                @foreach($my_widget as $widget)
                    @if(file_exists(base_path().'/resources/views/widgets/'.$widget->template.'.blade.php') && $widget->template !='')
                        @include('widgets.'.$widget->template)                        
                    @endif
                @endforeach
            @else
                <div class="text-right m-t-md m-b-md">

                            <i class="fa fa-hand-o-up fa-4x"></i>
                            <div class="m-t"> Select What you want to show .</div>

                     


                </div>

            @endif    

            </div>
        </div>    
    </div>
</div> 
</div>
<script type="text/javascript">
        
    $(function(){
        $('.set_widget').on('click',function(){
            var fields = $( ".mywidget-form :input" ).serializeArray();
            $.post('{{ url("dashboard") }}',fields,function( callback ){
                if(callback.status =='success'){
                    notyMessage(" Please wait , load new configuration !");
                    window.location.href ='{{ url("dashboard") }}';
                }
            })
            //alert(fields);
        })
    })


</script>
@stop