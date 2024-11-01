jQuery(document).ready(function() {

    if(sessionStorage.getItem('wpexitoptin_popup') != 'shown' && localStorage.getItem('wpexitoptin_popup') != 'shown' ){

      // if you want to use the 'fire' or 'disable' fn,
      // you need to save OuiBounce to an object
      var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        aggressive: true,
        timer: 0,
        callback: function() { 
          sessionStorage.setItem('wpexitoptin_popup','shown');
        }
      });

      jQuery('body').on('click', function() {
        jQuery('#ouibounce-modal').hide();
      });

      jQuery('#ouibounce-modal .modal-footer').on('click', function() {
        jQuery('#ouibounce-modal').hide();
      });

      jQuery('#ouibounce-modal .modal').on('click', function(e) {
        e.stopPropagation();
      });

    }

    jQuery('#ouibounce-modal .modal form').submit( function( event ){
        localStorage.setItem('wpexitoptin_popup','shown');
        return;
    });

});


function explode(){

  if(sessionStorage.getItem('wpexitoptin_popup') != 'shown' && localStorage.getItem('wpexitoptin_popup') != 'shown' ){
      jQuery('#ouibounce-modal').show();
      sessionStorage.setItem('wpexitoptin_popup','shown');
  }

}
setTimeout(explode, 1000);