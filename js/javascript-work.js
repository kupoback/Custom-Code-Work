(function($) {
  'use strict';
  
  function slideTab() {
    var tab = $( '.tab' ),
        con = $( '.pull-tab' ),
        bod = $( 'html body' );
    
    con.hide();
    con.find( tab ).hide();
    
    tab.on( 'click', function(e) {
      bod.toggleClass( 'folder-open' );
      con.toggle("slide");
      con.find( tab ).toggle( 'slide' );
    })
  
    function clickActions(){
      if ( bod.hasClass( 'folder-open' ) ) {
        bod.removeClass( 'folder-open' );
        con.toggle( 'slide' );
        con.find( tab ).hide();
      }
    }
    
    $('.overlay').on('click', function () {
      clickActions();
    })
    $( '.site-header' ).on( 'click', function() {
      clickActions();
    })
    
    $( '.close' ).on( 'click', function() {
      clickActions();
    })
    
  }
  
  // Calls to functions
  $(function() {
    slideTab();    
  })
  
})(jQuery);
