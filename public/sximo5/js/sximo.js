/* Sximo builder & Sximo 5 Inc 
	copyright 2014 . sximo builder com  & Sximo5.net
*/

jQuery(document).ready(function($){
	
	if($.cookie("sximo-sidebar") =='minimize-sidemenu'){
		$("body").addClass("minimize-sidemenu");
		$('#sidemenu').removeClass('expanded-menu');
	} else {
		$("body").removeClass("minimize-sidemenu");
		$('#sidemenu').addClass('expanded-menu');
	}
	$(window).bind("load resize",function(){
		if ($(this).width() < 769) {
			$('body').addClass('body-small')
		} else {
			$('body').removeClass('body-small')
		}

	})

	$(window).on("resize",function(){ 
		scrollmenu() 
		outlook() 
	});	

	  /*Return to top*/
	  var offset = 220;
	  var duration = 500;
	  var button = $('<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>');
	  button.appendTo("body");
	  
	  jQuery(window).scroll(function() {
	    if (jQuery(this).scrollTop() > offset) {
	        jQuery('.back-to-top').fadeIn(duration);
	    } else {
	        jQuery('.back-to-top').fadeOut(duration);
	    }
	  });

	jQuery('.back-to-top').click(function(event) {
	  event.preventDefault();
	  jQuery('html, body').animate({scrollTop: 0}, duration);
	  return false;
	});

	
	$('#sidebar-navigation').on('hover',function () {
		$(this).addClass('expanded-menu')
	})
	$('.child-menu').hover(function(){
		$(this).addClass('open');
	}).mouseleave(function(){ $(this).removeClass('open')});
	
  	$(".select2").select2({ width:"100%"});
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
	$('.panel-trigger').click(function(e){
		e.preventDefault();
		$(this).toggleClass('active');
	});

	$('.dropdown, .btn-group').on('show.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).fadeIn(100);
	});
	$('.dropdown, .btn-group').on('hide.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).fadeOut(100);
	});
	$('.popup').click(function (e) {
		e.stopPropagation();
	});	
     window.prettyPrint && prettyPrint();

	$('.nav li ul li.active').parents('li').addClass('active');

    $('.navbar-minimalize').click(function () {
      var w = $("body");
		w.toggleClass("minimize-sidemenu");
			
		if( w.hasClass('minimize-sidemenu'))
		{
			$('#sidemenu').removeClass('expanded-menu');
			$.cookie("sximo-sidebar",'minimize-sidemenu', {expires: 365, path: '/'});
		} else {
			$('#sidemenu').addClass('expanded-menu');
			 $.cookie("sximo-sidebar",'maximaze-sidemenu', {expires: 365, path: '/'});	
		}		
    })	
    $('#sidemenu li:has(> ul)').addClass('parents')
	$('.clearCache').click(function(){
		$('.ajaxLoading').show();
		var url = $(this).attr('href');
		$.get( url  , function( data ) {
		 $('.ajaxLoading').hide();
		 notyMessage(data.message); 
		     
		});
		return false;
	}); 
	$('.confirm_logout').on('click',function(){
		if(confirm('Logout from application ?'))
		{
			return true;
		}
		return false;
	})
	jQuery('.sidebar-collapse').scrollbar();	
	jQuery('.outlook-inner').scrollbar();	
})

function scrollmenu(){
	sidebar_height = $( window ).height() - 85;
	$('.sidebar-collapse').css('height',sidebar_height+'px');	
}
function outlook(){
	outlook_height = $( window ).height() - 135;
	$('.outlook-inner').css('height',outlook_height+'px');	
}

function SximoConfirmDelete( url )
{
	if(confirm('Are u sure deleting this record ? '))
	{
		window.location.href = url;	
	}
	return false;
}
function SximoDelete(  )
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(confirm('are u sure removing selected rows ?'))
	{
		$('#SximoTable').submit();// do the rest here	
	}	
}	
function SximoModal( url , title)
{
	
	$('#sximo-modal-content').html(' ....Loading content , please wait ...');
	$('.modal-title').html(title);
	$('#sximo-modal-content').load(url,function(){
	});
	$('#sximo-modal').modal('show');	
}

function notyMessage(message)
{

	 $.toast({
	    heading: 'success',
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
	    heading: 'error',
	    text: message,
	    position: 'top-right',		           
	    icon: 'error',
	    hideAfter: 3000,
	    stack: 6
	});

	
}

;(function ($, window, document, undefined) {

    var pluginName = "sximMenu",
        defaults = {
            toggle: true
        };

    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {

            var $this = $(this.element),
                $toggle = this.settings.toggle;

            $this.find('li.active').has('ul').children('ul').addClass('collapse in');
            $this.find('li').not('.active').has('ul').children('ul').addClass('collapse');

            $this.find('li').has('ul').children('a').on('click', function (e) {
                e.preventDefault();

                $(this).parent('li').toggleClass('active').children('ul').collapse('toggle');

                if ($toggle) {
                    $(this).parent('li').siblings().removeClass('active').children('ul.in').collapse('hide');
                }
            });
        }
    };

    $.fn[ pluginName ] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
