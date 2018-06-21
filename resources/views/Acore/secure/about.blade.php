@extends('layouts.app')


@section('content')
    <section class="page-header row">
        <h3> Eracor 5 Ultimate <small> Ver 2.0 </small> </h3>
        <ol class="breadcrumb">
            <li><a href="{{ url('dashboard')}}"> Home </a></li>
            <li class="active"> Eracor Released</li>
        </ol>
    </section>
    <div class="page-content row">
        <div class="page-content-wrapper no-margin">
            <div class="sbox"  >
                <div class="sbox-title">
                    <h3> Change Logs Versioning  </h3>
                </div>
                <div class="sbox-content about">

                    <div class="m-b">
                        <p>Eracor 5 Ultimate is a powerful automation tool that can generate a full set of PHP quickly from MySQL. You can instantly create web sites that allow users to view, edit, search, add and delete records on the web.
                            It's designed for high flexibility, numerous options enable you to generate PHP applications that best suits your needs. The generated codes are clean, straightforward and easy-to-customize.</p>
                    </div>
                    <hr />


                    <h4> Version 2.0.0 RC</h4>
                    <p> Date Relase : November 15 , 2017 </p>

                    <ul>
                        <li> <label class="label label-info"> New Feature</label> Personal Dropzone   </li>
                        <li> <label class="label label-info"> New Feature</label>  Personal Note   </li>
                        <li> <label class="label label-info"> New Feature</label> Setting Personal Widget   </li>
                        <li> <label class="label label-info"> New Feature</label> Widgets management   </li>
                        <li> <label class="label label-info"> Enhancment</label> Sort and order table   </li>
                        <li> <label class="label label-danger"> Bug Fix</label> Form Wizard </li>
                        <li> <label class="label label-danger"> Bug Fix</label> Form Tab </li>
                        <li> <label class="label label-info"> Enhancment</label> Form Series  </li>
                        <li> <label class="label label-danger"> Bug Fix</label> Format Function Grid </li>
                        <li> <label class="label label-danger"> Bug Fix</label> Global users access ( EntryBy ) </li>
                        <li> <label class="label label-success"> New Feature</label>  Adding shortcode page for generated Crud</li>
                    </ul>

                </div>


            </div>

        </div>
    </div>
    <style type="text/css">
        .about ul { list-style: none; margin:0; padding: 0 }
    </style>
@stop
