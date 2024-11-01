function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
  }

jQuery(document).ready(function() {

    var wpexitoptin_popup = getCookie('wpexitoptin_popup');

    if(wpexitoptin_popup != 'shown' && wpexitoptin_popup != 'submit' ){

      // if you want to use the 'fire' or 'disable' fn,
      // you need to save OuiBounce to an object
      var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        aggressive: true,
        timer: 0,
        callback: function() { 
          setCookie('wpexitoptin_popup', 'shown', 1);
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
        setCookie('wpexitoptin_popup', 'submit', 1);
    });

});
