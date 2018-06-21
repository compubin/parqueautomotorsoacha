
    <div class="outlook clearfix">
      <div class="outlook-left" >
        <div class="outlook-inner"> 
          <div class="title">
          <a href="{!! url('dashboard/note?task=create') !!}" class="btn btn-sm btn-default btn-sm edit-note"><i class="fa fa-plus"></i> Create New Note </a>
           </div>         
          <ul class="lists">
            @foreach($rows as $row)
              <li>
                <a href="{!! url('dashboard/note?task=update&id='.$row['tb_notes.note_id']) !!}" class="edit-note">
                    <b> {{ $row['tb_notes.title'] }} </b><br />
                    <span class="date"> {{ AppHelper::get_time_ago(strtotime($row['tb_notes.Created']))}}</span>

                 </a> 
              </li>
            @endforeach
          </ul>  
          </div>
        </div>
        <div class="outlook-content">

            

        </div>
      </div>        


<script type="text/javascript">
$(function(){
  $('.edit-note').on('click',function() {
      $.get( $(this).attr('href') , function( callback) {
          $('.outlook-content').html( callback )
      })
      return false;
  })
});
</script>
@include('CrudEngine.default.table_footer')