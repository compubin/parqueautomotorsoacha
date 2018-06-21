<script type="text/javascript">
	$(document).ready(function(){
		/* Intercept if link direct */
		<?php if(isset($direct) && $direct  !='' ) { 
			$url = url($url . '?'. $direct);
			?>
			$.get( '<?php echo $url;?>',function( callback ){
				<?php if(in_array("view", $direct_array)) {?>
				 $('#{{ $actionId}}').toggle();
				 $('#{{ $actionId}}-form').html( callback );
				<?php } ?> 
			})
			
		<?php } ?>

		$('th.insort').on('click',function(){
			var field = $(this).data('field');
			if($(this).hasClass('asc-sort'))
			{
				$('th.insort').attr('class','insort')
				$(this).addClass('desc-sort');
				insort = 'desc';
			}
			else if($(this).hasClass('desc-sort'))
			{
				$('th.insort').attr('class','insort')
				$(this).addClass('asc-sort');
				insort = 'asc';
			}
			else
			{
				$('th.insort').attr('class','insort')
				$(this).addClass('asc-sort');
				insort = 'asc';
			}	

			CrudEngineReload( '{{ url($url."?rows=10") }}&order=' + field + '&sort='+ insort , '#{{ $actionId }}' );

		});
		
	 	$('#<?php echo $actionId ;?>').crudEngine({
	    	action  : '<?php echo url($url);?>',
	    	id 		:  '#{{ $actionId }}'
	    });

		$("#<?php echo $actionId ;?> ul.pagination li a").addClass("page-link")
		$("#<?php echo $actionId ;?> ul.pagination li a ").on("click",function(){
			return false;
		});
		$('#perpage').on('change',function(){

			CrudEngineReload( '{{ url($url."?rows=") }}' + $(this).val() , '#{{ $actionId }}' );
		})
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

	    $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
	      checkboxClass: 'icheckbox_square-green',
	      radioClass: 'iradio_square-green'
	    }); 	
		$('.checkall').on('ifChecked', function(event) {
		    $('.ids').iCheck('check');
		});
		$('.checkall').on('ifUnchecked', function(event) {
		    $('.ids').iCheck('uncheck');
		}); 		


	})
</script>