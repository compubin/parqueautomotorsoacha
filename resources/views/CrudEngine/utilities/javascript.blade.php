<script type="text/javascript">
	$(document).ready(function(){

	 	$('#<?php echo $actionId ;?>').sClass({
	    	action  : '<?php echo url($url);?>',
	    	id 		:  '#{{ $actionId }}'
	    });

		$("#<?php echo $actionId ;?> ul.pagination li a").addClass("page-link")
		$("#<?php echo $actionId ;?> ul.pagination li a ").on("click",function(){
			var link = $(this).attr('href');
			return false;
		});
		/* if search is entered */
		$( '#<?php echo $actionId ;?> input[name=onsearch]').keyup(function( e ){
			if (e.keyCode === 13) {
		       CrudEngineReload( '{{ url($url."?search=")}}'+$(this).val() , '#{{ $actionId}}');
		    }
		})	
		$('#<?php echo $actionId ;?> .checkall').on('click',function() {
			var cblist = $(".ids");
			if($(this).is(":checked"))
			{				
				cblist.prop("checked", !cblist.is(":checked"));
			} else {	
				cblist.removeAttr("checked");
			}	
		});
	})
</script>
