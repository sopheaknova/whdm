

(function($)
{
	
  /*--------------------------------------------------------------------------------------*/
  /*  Primary navigation
  /*--------------------------------------------------------------------------------------*/
  $( 'ul.primary-nav li' ).each(function(){
    var submenu = $(this).find('ul:first');
    $(this).hover(function(){
      submenu.stop().slideDown(250, function(){
                                      $(this).css({overflow:"visible", height:"auto"});
                                    });
    }, function(){
      submenu.stop().slideUp(250, function(){ 
                                      $(this).css({overflow:"hidden", display:"none"});
                                    });
    });
  });



}(jQuery));