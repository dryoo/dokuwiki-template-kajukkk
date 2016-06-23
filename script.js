  /* day/night toggle  */
  function tpl_toggleLight() {
     if (DokuCookie.getValue('dark')==1)
     {
          DokuCookie.setValue('dark','0');
        jQuery('body').toggleClass('dark');
        return false;
     }
     else
     {
        DokuCookie.setValue('dark','1');
        jQuery('body').toggleClass('dark');
        return false;
      }
   }


(function($) {
    var fadeOption = {duration: 0};
    var device_class = ''; // not yet known
    var device_classes = 'mobile wide desktop tablet phone';
    var resizeTimer;
    function toggleLeft() {
        $('#nav_bg').show('fade', fadeOption);
        $('#dokuwiki__nav').show();
    }

    function toggleRight() {
        $('#sidebar_bg').show('fade', fadeOption);
        $('#dokuwiki__aside').show();
    }

    function preventParentWheel(e) {
        var curScrollPos = $(this).scrollTop();
        var scrollableDist = $(this).prop('scrollHeight') - $(this).outerHeight();
        var wheelEvent = e.originalEvent;
        var dY = wheelEvent.deltaY;

        if (dY < 0 && curScrollPos <= 0) {
            return false;
        }
        if (dY > 0 && curScrollPos >= scrollableDist) {
            return false;
        }
    }

    function checkWidth() {
        // the z-index in mobile.css is (mis-)used purely for detecting the screen mode here
    var screen_mode = jQuery('#screen__mode').css('z-index') + '';

    // determine our device pattern
    // TODO: consider moving into dokuwiki core
    switch (screen_mode) {
        case '1':
            if (device_class.match(/phone/)) return;
            device_class = 'mobile phone';
			$('#dokuwiki__aside').hide();
            break;
        case '2':
            if (device_class.match(/tablet/)) return;
            device_class = 'mobile tablet';
			$('#dokuwiki__aside').hide();
            break;
        case '3':
            if (device_class.match(/desktop/)) return;
            device_class = 'desktop';
			$('#dokuwiki__aside').show();
            break;            
        default:
            if (device_class.match(/wide/)) return;
			$('#dokuwiki__aside').show();
            device_class = 'wide';
    }

    jQuery('html').removeClass(device_classes).addClass(device_class);
    }
    
    
    function bindEvents() {
        $('.sidebar').on('wheel scroll', preventParentWheel);
        $('.btn_left').click(function() {
            toggleLeft();
        });
        $('.btn_left').mouseover(function() {
            jQuery('.btn_left i').addClass('fa-spin'); 
        });
        $('.btn_right').click(function() {
            toggleRight();
        });
        $('#sidebar_bg').click(function() {
            $(this).hide('fade', fadeOption);
            if (device_class.match(/mobile/))  
            $('#dokuwiki__aside').hide();
        });
        $('#nav_bg').click(function() {
            $(this).hide('fade', fadeOption);
            $('#dokuwiki__nav').hide();
			jQuery('.btn_left i').removeClass('fa-spin');
        });		
        $('.btn_search').click(function() {
            $('div.search').toggle();
            $('div.search').find('input.edit').focus();
        });
        jQuery(window).bind('resize',
        function(){
            if (resizeTimer) clearTimeout(resizeTimer);
            resizeTimer = setTimeout(checkWidth,200);
        });
    }

    function initUI() {
        // Move TOC
        if ($('.page h2').length > 0) {
            $('#dw__toc').insertBefore($('.page h2:first'));
        } else {
            $('#dw__toc').insertAfter($('.page h1:first').next('.level1'));
        }
        // Anchor link should be shifted by header pixel
        $(window).on("hashchange", function () {
            window.scrollTo(window.scrollX, window.scrollY - 48);
        });
    }

    $(function() {
        initUI();
         checkWidth();
        bindEvents();
    });
})(jQuery);