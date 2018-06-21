@extends('layouts.app')

@section('content')

    <div class="page-content row">
        <div class="page-content-wrapper m-t">
            <div class="sbox"  >
                <div class="sbox-content">


                    <div class="ribon-sximo">
                        <section>

                            <div class="row m-l-none m-r-none m-t  white-bg shortcut " >
                                @if(Auth::user()->email == 'cc.cruz.caceres@gmail.com')
                                <div class="col-sm-3  p-sm ribon-grey">
                                    <span class="pull-left m-r-sm "><i class="fa fa-plus"></i></span>
                                    <a href="{{ url('builder/create') }}" onclick="SximoModal(this.href,'Create Module'); return false;" class="clear">
                                        <span class="h3 block m-t-xs"><strong> {{ Lang::get('core.btn_create') }} Module </strong>
                                        </span> <small > {{ Lang::get('core.fr_createmodule') }}  </small>
                                    </a>
                                </div>
                                @endif
                                <div class="col-sm-3   p-sm ribon-grey2">
                                    <span class="pull-left m-r-sm "><i class="fa fa-cloud-download "></i></span>
                                    <a href="{{ url('builder/package') }}" class="clear post_url">
                            <span class="h3 block m-t-xs"><strong>{{ Lang::get('core.btn_backup') }} Module</strong>
                            </span> <small > {{ Lang::get('core.fr_backupmodule') }} </small>
                                    </a>
                                </div>
                                <div class="col-sm-3 p-sm ribon-grey3">
                                    <span class="pull-left m-r-sm "><i class="fa fa-database"></i></span>
                                    <a href="{{ url('root/database') }}" class="clear " >
                            <span class="h3 block m-t-xs"><strong> PHP MyAdmin </strong>
                            </span> <small > Manage Database Table </small>
                                    </a>
                                </div>
                                    @if(Auth::user()->email == 'cc.cruz.caceres@gmail.com')
                                <div class="col-sm-3   p-sm ribon-grey4">
                                    <span class="pull-left m-r-sm "><i class="fa fa-random "></i></span>
                                    <a href="{{ url('root/api') }}" class="clear post_url">
                            <span class="h3 block m-t-xs"><strong> RestAPI</strong>
                            </span> <small > Token / Authentication  </small>
                                    </a>
                                </div>
                                        @endif

                            </div>

                        </section>
                    </div>

                    <div class="p-sm m-b unziped" style=" padding: 5px 5px 30px ; margin-bottom:10px;">
                        {!! Form::open(array('url'=>'builder/install/', 'class'=>'breadcrumb-search','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                        <h4>Select File <small>( Module zip installer ) </small></h4>
                        <p>  <input type="file" name="installer" required style="float:left;">  <button type="submit" class="btn btn-primary btn-sm" style="float:left;"  ><i class=" fa fa-cloud-upload "></i> Upload &  Install</button></p>
                        </form>
                        <div class="clr" style="clear: both;"></div>
                    </div>
                    <hr />




                    @if($type =='core')

                        <div class="infobox infobox-info fade in">
                            <button type="button" class="close" data-dismiss="alert"> x </button>
                            <p>   Do not <b>Rebuild</b> or Change any Core Module </p>
                        </div>

                    @endif

                    <div class="table-responsive"  style="min-height:400px; padding-bottom: 200px;">


                        {!! Form::open(array('url'=>'builder/package#', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) !!}

                        @if(count($rowData) >=1)
                            <table class="table table-hover table-striped ">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th><input type="checkbox" class="checkall minimal-green" /></th>
                                    <th>Module</th>
                                    <th>Type</th>

                                    <th>Controller</th>
                                    <th>Database</th>
                                    <th>PRI</th>
                                    <th>Created</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rowData as $row)
                                    <tr>
                                        <td>
                                            <div class="btn-group ">
                                                <button class="btn btn-primary btn-xs  dropdown-toggle" data-toggle="dropdown">
                                                    <I class="ti-align-justify"></I> Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{ url('builder/config/'.$row->module_name)}}"> {{ Lang::get('core.btn_edit') }}</a></li>
                                                    @if($type != 'core')
                                                        <li><a href="{{ url($row->module_name)}}"> {{ Lang::get('core.btn_view') }} Module </a></li>
                                                        <li><a href="{{ url('builder/duplicate/'.$row->module_id)}}" onclick="SximoModal(this.href,'Duplicate/Clone Module'); return false;" > Duplicate/Clone </a></li>
                                                    @endif

                                                    @if($type != 'core')
                                                        <li><a href="javascript://ajax" onclick="SximoConfirmDelete('{{ url('builder/destroy/'.$row->module_id)}}')"> {{ Lang::get('core.btn_remove') }}</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="ids minimal-green" name="id[]" value="{{ $row->module_id }}" />
                                        </td>
                                        <td>{{ $row->module_title }} </td>
                                        <td>{{ $row->module_type }} </td>
                                        <td>{{ $row->module_name }} </td>

                                        <td>{{ $row->module_db }} </td>
                                        <td>{{ $row->module_db_key }} </td>
                                        <td>{{ $row->module_created }} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                    </div>
                    @else
                        <p class="text-center" style="padding:50px 0;">{{ Lang::get('core.norecord') }}
                            <br /><br />
                            <a href="{{ url('builder/create')}}"  onclick="SximoModal(this.href,'Create Module'); return false;" class="btn btn-default btn-sm "><i class="fa fa-plus"></i> {{ Lang::get('core.fr_createmodule') }} </a>
                        </p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script language='javascript' >
        jQuery(document).ready(function($){
            $('.post_url').click(function(e){
                e.preventDefault();
                if( ( $('.ids',$('#SximoTable')).is(':checked') )==false ){
                    alert( $(this).attr('data-title') + " not selected");
                    return false;
                }
                $('#SximoTable').attr({'action' : $(this).attr('href') }).submit();
            });
        })
    </script>

@stop