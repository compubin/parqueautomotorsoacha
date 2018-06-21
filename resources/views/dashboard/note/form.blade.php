<div class="note-content">
 {!! Form::open(array('url'=>'dashboard/note', 'class'=>'form-horizontal CrudEngineForm','files' => true , 'id' =>'mynote' ,'parsley-validate'=>'','novalidate'=>' ')) !!}

    <div class="note-title ">
        
        <a href="javascript://ajax" class="btn btn-sm  pull-right btn-sm" onclick="$('.outlook-content').empty();"><i class="fa fa-times"></i> </a>
        <input class="form-control" value="{{ $row['title'] }}" required="true" name="title" />
    </div>
    <div class="note-body">
        <textarea class="CrudEngineEditor form-control"  name="notes" id="notes">{!! $row['notes'] !!}</textarea>

    </div>
    <div class="note-footer">
        <div class="btn-group">
            <button class="btn btn-sm btn-default saved"><i class="fa fa-thumbs-o-up"></i> Save</button>
            <a class="btn btn-sm btn-default deleted"><i class="fa fa-trash"></i> Remove</a>
        </div>
    </div>
    <input type="hidden" name="note_id" value="{{ $row['note_id'] }}" />
     <input type="hidden" name="user_id" value="{{ session('uid') }}" />
    <input type="hidden" name="ids[]"  value="{{ $row['note_id'] }}" />
    <input type="hidden" name="task" value="{{ $task_value }}" />
    <input type="hidden" name="data-after-task" id="data-after-task" value="" />    
    {!! Form::close() !!}
</div>
<style type="text/css">
  .note-editor{ 
  border: none !important;
}

</style>
<script type="text/javascript">
$(function(){
  $('#notes').summernote({
    height: 280
 
  })
  $('.deleted').on('click',function() {
    if(confirm('Are u sure ?')){
           $.post('{{ url("dashboard/note") }}', { 'ids[]': ['{{ $row["note_id"] }}'] , task :'delete'} , function(data){
             notyMessage(data.message);
             window.location.href = '{{ url("dashboard/note") }}';
           })
     } 
     return false;      
  });

var form = $('#mynote'); 
        form.parsley();
        form.submit(function()
        {         
          if (form.parsley().isValid())
          {      
            var options = { 
              dataType:      'json', 
              beforeSubmit : function() {
                var text_content = $('.CrudEngineEditor ').html();
                $('#notes').val( text_content );

              },
              success: function( data ) {
                  if(data.status == 'success')
                  {
                    notyMessage(data.message);
                    if(data.after =='update')
                    {
                        $('input[name={{ $this_key}}]').val(data.id);   
                    } 
                    else if(data.after =='insert') {
                        form.trigger('reset');
                    }
                    else {
                      
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
});
</script>
