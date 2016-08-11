(function() {
  // Store the slider in a local variable
  var $window = jQuery(window),
      flexslider,
      resizeEnd;

  $window.load(function() {
    initFlexslider();
  });

  // Check grid size on resize event
  $window.resize(function() {
    // Check if we use slider on this page
    if (jQuery('.ka-related-products .flexslider').length > 0) {
      clearTimeout(resizeEnd);

      resizeEnd = setTimeout(function() {
        flexslider.destroy();
        initFlexslider();
      }, 200);
    }
  });

  function initFlexslider() {
    // Check if we use slider on this page
    if (jQuery('.ka-related-products .flexslider').length > 0) {
      jQuery('.ka-related-products .flexslider').flexslider({
        selector: '.slides > div',
        animation: 'slide',
        animationLoop: true,
        itemWidth: 292,
        itemMargin: 0,
        controlNav: false,
        prevText: '',
        nextText: '',
        minItems: flexsliderGridSize(), // use function to pull in initial value
        maxItems: flexsliderGridSize(), // use function to pull in initial value
        start: function(slider) {
          flexslider = slider;
        }
      });
    }
  }

  // Tiny helper function to add breakpoints
  function flexsliderGridSize() {
    var vpWidth = window.innerWidth,
        visibleSlides = 4;

    if (vpWidth > 980 && vpWidth <= 1450) {
      visibleSlides = 3;
    }
    else if (vpWidth > 600 && vpWidth <= 980) {
      visibleSlides = 2;
    }
    else if (vpWidth <= 600) {
      visibleSlides = 1;
    }
    return visibleSlides;
  }
}());
