// Global Scope
var dotdotdotSelectors = new Array(
  '.ka-product-title',
  '.ka-product-desc'
  ).join(', ');

/**
* Document Ready Event
*/
jQuery(document).ready(function() {
  // displayCurrentWindowSize();
});

/**
* Window Load Event
*/
jQuery(window).load(function() {
  attachDotDotDot(dotdotdotSelectors);
});

/**
* Window Resize Event
*/
(function() {
  jQuery(window).on('resize', function(e) {
    // displayCurrentWindowSize();
    setTimeout(function() {
      jQuery(dotdotdotSelectors).trigger('update.dot');
    }, 300);
  });
})();

/**
* Display Current Window Size
*
* @return [null]
*/
function displayCurrentWindowSize() {
  var el = document.getElementById('current-window-size');

  if (el == null) {
    el = document.createElement('div');
    el.setAttribute('id', 'current-window-size');
    el.style.position = 'fixed';
    el.style.top = 0;
    el.style.right = '20px';
    el.style.zIndex = 300000;
    document.body.appendChild(el);
  }

  el.innerHTML = window.innerWidth + ' x ' + window.innerHeight;
}

/**
* Simple AJAX Call Handler
*
* @param [string] action - callback name on server side
* @param [string] security - hashed security key
* @param [object] data - data send to callback
* @param [function] successFunction - callback name after response
* @param [string] dataType - received data type
*
* @return [null]
*/
function ajaxLoadHandler(action, security, data, successFunction, dataType) {
  if (typeof dataType == 'undefined') {
    dataType = 'html';
  }

  var loaderOverlay = jQuery('<div class="loader-overlay"></div>');

  jQuery('body').append(loaderOverlay);

  setTimeout(function() {
    loaderOverlay.addClass('on');
  }, 50);

  jQuery.ajax({
    type: 'POST',
    dataType: dataType,
    url: localizedVars.ajaxUrl,
    data: {
      action: action,
      security: security,
      data: data
    },
    success: function(response) {
      successFunction(response);
      loaderOverlay.removeClass('on');
      setTimeout(function() {
        loaderOverlay.remove();
      }, 400);
    }
  });
}

/**
* Mobile Detetion
*
* @return [true|false] - true if user agent is mobile or false otherwise
*/
function isMobile() {
  var pattern_1 = /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i;
  var pattern_2 = /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i;

  if (pattern_1.test(navigator.userAgent) || pattern_2.test((navigator.userAgent || navigator.vendor || window.opera).substr(0, 4))) {
    return true;
  }
  return false;
}

/**
* Footer Positioning On Page When The Content Height Can't Fill The Page Height
*
* @param [object] target - footer element to set position
* @param [object] el - array of elements to define content height
*
* @return [null]
*/
function footerPositioning(target, el) {
  try {
    var vpHeight = window.innerHeight,
        contentHeight = 0;

    if (typeof target === typeof undefined) {
      throw new FooterPositioningException('Pass to empty argument', 'target', target);
    }

    if (typeof el === typeof undefined) {
      throw new FooterPositioningException('Pass to empty argument', 'el', el);
    }

    try {
      jQuery(el).each(function() {
        contentHeight += jQuery(this).outerHeight(true);
      });

      if (vpHeight >= contentHeight) {
        target.css({
          position: 'fixed',
          bottom: 0
        });
      }
      else {
        target.css({
          position: 'relative',
          bottom: 'auto'
        });
      }
    }
    catch (e) {
      console.log(e);
    }
  }
  catch (e) {
    if (e instanceof FooterPositioningException) {
      e.logMsg();
    }
    else {
      console.log(e);
    }
  }
};

/**
* Exception Handler For `footerPositioning` Function
*
* @param [string] message - message text
* @param [string] variableName - variable name
* @param [string] variableValue - variable value
*
* @return [null]
*/
function FooterPositioningException(message, variableName, variableValue) {
  this.name = 'FooterPositioningException';
  this.message = message || 'Message is not defined';
  this.variableName = variableName || 'Variable name is not defined';
  this.variableValue = variableValue || 'Variable value is not defined';
  this.logMsg = function() {
    console.log(this.name + ': ' + this.message + ' [' + this.variableName + ' => ' + this.variable + ']');
  };
};

/**
* Trancate Text With `dotdotdot`
*
* @param [string] selectors - comma-separated selectors
*
* @return [null]
*/
function attachDotDotDot(selectors) {
  try {
    jQuery(selectors).dotdotdot({
      wrap: 'letter',
      watch: 'window'
    });
  }
  catch(e) {
    // console.log(e);
  }
}

/**
* Detach `dotdotdot`
*
* @param [string] selectors - comma-separated selectors
*
* @return [null]
*/
function detachDotDotDot(selectors) {
  try {
    jQuery(selectors).trigger('destroy');
  }
  catch(e) {
    // console.log(e);
  }
}
