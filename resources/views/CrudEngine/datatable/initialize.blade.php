<?php
$cols = '{"data":"rowId"}, {"data":"checkbox"},';

?>
<div class="" id="{{ $actionId}}View">	</div>
<div class="" id="{{ $actionId}}Grid">
    @if($type =='crud')
        @include( 'CrudEngine.datatable.toolbar')
    @endif

    <div class="table-responsive">
        <table id="{{ $actionId }}Table" class="display table table-striped" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th> <input type="checkbox" class="checkall  minimal-green" />	 </th>
                <?php foreach($fields as $key=>$val) :
                $field = explode(".",$key);
                $cols .= '{"data":"'.$field[1].'"},';
                ?>
                <th> {{ $val }}</th>
                <?php endforeach;
                if(isset($button['view']) || isset($button['update']))
                {
                    $cols .= '{"data":"action"}';
                } else {
                    $cols = substr($cols,0,strlen($cols)-1) ;
                }
                ?>
                <?php if(isset($button['view']) || isset($button['update'])) { ?>
                <th class="text-right"> Action</th>
                <?php } ?>
            </tr>
            </thead>

        </table>
    </div>
</div>

<!-- Modal Start-->
<div class="modal fade" id="CrudEngineModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-default">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>

            <div class="modal-body" id="CrudEngineModal-content">

            </div>

        </div>
    </div>
</div>
<!-- Modal End -->
<script type="text/javascript">

    $(document).ready(function() {

        var rows_selected = [];
        var table = $('#{{ $actionId }}Table').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url($url) }}",
                "type": "POST",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            "language": <?php echo json_encode(__('datatable'));?> ,
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            'order': [[1, '{{ $order_type}}']],
            "columns": [<?php echo $cols;?>]
        });

        var _token = '{{ csrf_token() }}';
        var action = '{{ url($url) }}';
        var tableId = '#{{ $actionId }}';

        var gridData 	= '#{{ $actionId }}Table';
        var gridTbl 	= '#{{ $actionId }}Grid';
        var gridView 	= '#{{ $actionId }}View';

        $( gridData +' tbody').on('click', 'tr.odd', function () { $(this).toggleClass('selected'); });
        $( gridData +' tbody ').on('click', 'tr.even', function () { $(this).toggleClass('selected'); });

        $('.Action_Row').click(function () {

            var code = $(this).attr('code');
            if( code =='refresh') { table.ajax.reload(); }
            if( code =='create') {
                var url = action + '?task=create';
                var mode = $(this).attr('mode');
                var title = $(this).data('original-title');
                if(mode =='native')
                {
                    CrudEngine_ViewDetail( tableId , url  );
                } else {
                    CrudEngineModal(  url  , title  );
                }
            }

            var rows = table.rows('.selected').data().length ;
            if(rows)
            {
                var id = table.row('.selected').data().rowId;

                if(code =='view')
                {
                    var url =  action + '?task=view&id='+id;
                    var mode = $(this).attr('mode');
                    var title = $(this).attr('title');
                    if(mode =='native')
                    {
                        CrudEngine_ViewDetail( tableId , url  );
                    } else {
                        CrudEngineModal(  url  , title  );
                    }



                }  else if(code =='copy') {

                    var rows = table.rows('.selected').data();
                    var ss = [];
                    for(var i=0; i<rows.length; i++){
                        var ids = rows[i].rowId;
                        ss.push(ids) ;
                    }
                    if(confirm('Are sure Clone/Copy selected row(s) ?'))
                    {
                        var url =  action ;
                        $.post( url  ,{ids:ss, task:"copy", _token: _token},function( data ) {
                            if(data.status =='success')
                            {
                                notyMessage(data.message);
                                table.ajax.reload();
                            } else {
                                notyMessageError(data.message);
                            }
                        });
                    }

                } else if(code =='update') {
                    var url = action + '?task=update&id='+id;
                    var mode = $(this).attr('mode');
                    var title = $(this).attr('title');
                    if(mode =='native')
                    {
                        CrudEngine_ViewDetail( tableId , url  );
                    } else {
                        CrudEngineModal(  url  , title  );
                    }

                } else if(code =='delete'){

                    var rows = table.rows('.selected').data();
                    var ss = [];
                    for(var i=0; i<rows.length; i++){
                        var ids = rows[i].rowId;
                        ss.push(ids) ;
                    }

                    if(confirm('Are sure Remove selected row(s) ?'))
                    {
                        var url =   action ;
                        $.post( url ,{ids:ss , task:"delete", _token: _token},function( data ) {
                            Pace.restart()
                            if(data.status =='success')
                            {
                                notyMessage(data.message);
                                table.ajax.reload();
                            } else {
                                notyMessageError(data.message);
                            }

                        });
                    }

                }
            }
        });

        /* if search is entered */
        $( '#<?php echo $actionId ;?>Grid input[name=onsearch]').keyup(function( e ){
            if (e.keyCode === 13) {
                table.search( this.value ).draw();
            }
        })

    });

    function CrudEngine_ViewDetail( id , url )
    {

        $.get( url ,function( data ) {
            $( id +'View').html( data );
            $( id +'Grid').hide( );
        });

    }

    function CrudEngine_Close( id )
    {
        $( id +'View' ).html('');
        $( id +'Grid' ).show();
        $('#CrudEngineModal').modal('hide');
    }

    function CrudEngine_print(url ,w , h)
    {
        var w = (w == '' ? w : 800 );
        var h = (h == '' ? wh: 600 );
        newwindow=window.open(url,'name','height='+w+',width='+h+',resizable=yes,toolbar=no,scrollbars=yes,location=no');
        if (window.focus) {newwindow.focus()}
    }

    function loadNestedLookup(url , id )
    {
        if($(id).is(':empty'))
        {
            $(id).html('<p class"text-center" style="line-height:100px; text-align:center;"> Loading Content .... Please wait </p>');
            $.get(url,function(data)
            {
                $(id).load(url);
            })

        }
    }
</script>
<style type="text/css">
    .dataTables_filter {display: none;}
</style>