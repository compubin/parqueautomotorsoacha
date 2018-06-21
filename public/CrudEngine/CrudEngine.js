
(function($) {
    $.fn.crudEngine = function( options ) {

    	var settings = $.extend({
            action      : 'action'	     
        }, options);
        return this.each( function() {

			$(settings.id +' ul.pagination li a').on("click",function(){
				var link = $(this).attr('href');
				CrudEngineReload( link , settings.id );
				
			});

			$(settings.id +' .ajaxCallback').click(function () {
				var task = $(this).attr('code');
				var mode = $(this).attr('mode');
				var url = $(this).attr(settings.action);

				if(task =='create')	{
					var href = settings.action +'?task='+ task ;
					if(mode =='modal')
					{
						SximoModal(href , 'Create New');
					} else {
						$.get(href,function( data ){	
							$(  settings.id  ).hide( );		
							$(  settings.id +'-form' ).show(  );
							$(  settings.id +'-form' ).html( data );						
						});
					}
									
				} 
				else if(task =='view')	{
					var href = $(this).attr('href');
					if(mode =='modal')
					{
						SximoModal(href , 'Update Record ');
					} 
					else {	
						$.get(href,function( data ){	
							$(  settings.id  ).hide( );		
							$(  settings.id +'-form' ).show( );
							$(  settings.id +'-form' ).html( data );
							
						});	
					}	
					return false;			
				} 
				else if(task =='update')	{
					var href = $(this).attr('href');
					if(mode =='modal')
					{
						SximoModal(href , 'Update Record ');
					} 
					else {	
						$.get(href,function( data ){	
							$(  settings.id  ).hide( );		
							$(  settings.id +'-form' ).show(  );
							$(  settings.id +'-form' ).html( data );
							
						});	
					}	
					return false;
				}
				else if(task =='search')	{
					var href = settings.action +'?task=search';
					
					$.get(href,function( data ){	
						$(  settings.id  ).hide( );		
						$(  settings.id +'-form' ).show( );
						$(  settings.id +'-form' ).html( data );
						
					});	
					return false;					
				} 									
				else if(task =='remove_file')	{
					var href = $(this).attr('href');	
					return false;					
				} 
				else if(task =='download')	{
					var href = settings.action +'?task=download';	
					$.get(href,function( data ){

					});
					return false;
				}									
				else if( task =='copy') {
					var form = settings.id+ 'table'; 
					if(confirm('Areu sure copy selected row(s)'))
					{			
						$('#task').val('copy');
						var action = $(form).attr('action');
						var datas = $( form + ' :input').serialize();
						
						$.post( action ,datas,function( data ) {
							if(data.status =='success')
							{
								notyMessage(data.message );
								CrudEngineReload( settings.action , settings.id );

							} else {
								notyMessage(data.message );
							}	
										
						})
					}
				}	
				else if(task =='delete')	{
					var form = settings.id+ 'table'; 
					if(confirm('Areu sure delete selected row(s)'))
					{			
						$('#task').val('delete');
						var action = $(form).attr('action');
						var datas = $( form + ' :input').serialize();
						
						$.post( action ,datas,function( data ) {
							if(data.status =='success')
							{
								notyMessage(data.message );
								CrudEngineReload( settings.action , settings.id );

							} else {
								notyMessage(data.message );
							}		
							
						})
					}				
				} 
				else if( task =='close') {
					$( settings.id  ).show( );	
					$( settings.id +'-form' ).hide( data );
				}
				
			});
		})	
	}			


}(jQuery));

function CrudEngineModal( url)
{
	$('#CrudEngineModal-content').html(' ....Loading content , please wait ...');
	$('#CrudEngineModal-content').load(url,function(data){

	});
	$('#CrudEngineModal').modal('show');	
}


function CrudEngineLoad( href , id )
{
	$.get(href,function( data ){	
		$( id  ).show( );		
		$( id +'-form' ).show(  );
		$( id +'-form' ).html( data );
	});
}

function CrudEngineReload( href , id )
{
	
	$.get(href,function( data ){	
		$( id  ).html( data );	
		$( id  ).show();		
		$( id +'-form' ).hide(  );
		$( id +'-form' ).html( '' );
		
	});
}

function CrudEngine_Close( id )
{
	$( id +'-form' ).html('');	
	$( id +'-form' ).hide();
	$( id  ).show();	
	$('#CrudEngineModal').modal('hide');
	$('#sximo-modal').modal('hide');
	
}
function CrudEnginePrint(url )
{
	var w = 800 ;	
	var h =  600 ;	
	newwindow=window.open(url,'name','height='+w+',width='+h+',resizable=yes,toolbar=no,scrollbars=yes,location=no');
	if (window.focus) {newwindow.focus()}
}

function notyMessage(message)
{
	$.toast({
	    heading: 'Success',
	    text: message,
	    position: 'top-right',
	    icon: 'success',
	    hideAfter: 3000,
	    stack: 6
	});	
}
function notyMessageError(message)
{
	$.toast({
	    heading: 'Error',
	    text: message,
	    position: 'top-right',
	    icon: 'error',
	    hideAfter: 3000,
	    stack: 6
	});	
}

function sClassDelete(  id  )
{	
	if(confirm('Areu sure delete selected row(s)'))
	{
		$('#task').val('delete');
		var action = $(id).attr('action');
		var datas = $( id +'Table :input').serialize();
		alert(datas);
		$.post( action ,datas,function( data ) {
			if(data.status =='success')
			{
				notyMessage(data.message );
				//ajaxFilter( id ,url+'/data' );
			} else {
				notyMessage(data.message );
			}				
		});

	    return false; 
	}

}

function sClassCopy(  id  )
{	
	alert(id);
	if(confirm('Areu sure Copy selected row(s)'))
	{

		var form = $(id); 
		var options = { 
	      dataType:      'json', 
	      beforeSubmit : function() {
	       
	      },
	      success: function( data ) {
	          if(data.status == 'success')
	          {
	            notyMessage(data.message);
	            $('#sximo-modal').modal('hide'); 
	          } else {
	            notyMessageError(data.message);
	            return false;
	          }
	      }  
	    } 

	    $(this).ajaxSubmit(options); 
	    return false; 
	}    
}

$(function(){
	$("ul.pagination li a").addClass("page-link")
})