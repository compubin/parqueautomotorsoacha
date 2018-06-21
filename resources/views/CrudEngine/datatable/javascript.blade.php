<script type="text/javascript">
    $(function(){
        $('.addC').relCopy({});
        $('.CrudEngineDate').datepicker({format:'yyyy-mm-dd',autoClose:true});
        $('.CrudEngineDateTime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',autoClose:true});
        $('.CrudEngineTime').timepicker();
        $('.CrudEngineYear').datepicker({minViewMode: 2,format: 'yyyy'});
        $('.CrudEngineEditor').summernote({ height: 150});

        $('.removeMultiFiles').click(function(){
            var id = $(this).attr('rel');
            var url = $(this).attr('url');
            $.get('<?php echo url($url);?>?task=remove_file&file='+url ,function( callback ){
                if(callback.status =='success'){
                    notyMessage(callback.message);
                    $(id).remove();
                }
            })
        });

        $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('.actionButton').click(function () {
            var task = $(this).attr('data-after-task');
            $('#data-after-task').val(task);
            $('#{{ $actionId}}-action').submit();
        });

        $(".select2").select2({ width:"100%"});
        <?php if(count($javascript) >=1) {
        foreach($javascript as $js_key => $js_value) {
            $combo_url = url($url.'?task=combo&filter='.$js_value);
            $parent    = explode('parent=', $js_value);
        ?>
        $("#<?php echo $js_key ?>").jCombo("<?php echo $combo_url;?>",
            {
                @if(!empty($parent[1]))
                    parent: '#{!! rtrim($parent[1], ':') !!}',
                @endif
                selected_value : '{{ $row[$js_key]}}'
            });
        <?php } } ?>

        <?php if($form_view =='vertical') { ?>
        $('.CrudEngineForm').removeClass('form-horizontal').addClass('form-vertical');
        $('.CrudEngineForm .form-group').removeClass('row');
        $('.CrudEngineForm .form-group label').removeClass('col-md-3');
        $('.CrudEngineForm .form-group .col-md-9').removeClass('col-md-9');
            <?php } ?>

        var form = $('#{{ $actionId}}-action');
        form.parsley();

        form.submit(function()
        {
            if (form.parsley().isValid())
            {
                var options = {
                    dataType:      'json',
                    beforeSubmit : function() {
                        $('.ajaxLoading').show();
                    },
                    success: function( data ) {
                        if(data.status == 'success')
                        {
                            var table = $('#{{ $actionId}}Table').DataTable();
                            table.ajax.reload();

                            notyMessage(data.message);
                            if(data.after =='update')
                            {
                                $('input[name={{ $this_key}}]').val(data.id);
                            }
                            if(data.after =='insert') {
                                form.trigger('reset');
                            }
                            if(data.after =='return') {
                                CrudEngine_Close('#{{ $actionId}}')
                            }

                            $('.ajaxLoading').hide();


                        } else {
                            notyMessageError(data.message);
                            $('.ajaxLoading').hide();
                        }
                    }
                }
                $(this).ajaxSubmit(options);
                return false;
            }
            else {
                notyMessageError('Error ajax wile submiting !');
                return false;
            }
        });
    })
    function appendFormFiles(id){

        $("."+id+"Upl").append('<input type="file" name="'+id+'[]" />')
    }
</script>