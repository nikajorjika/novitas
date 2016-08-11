/**
 * Author: KAVELA
 *
 * How it works:
 *
 *  Add `data-fit-text` attribute to HTML element:
 *    - First parameter: Maximum size of font [numeric]
 *    - Second parameter: Maximum size of content wrapper [numeric]
 *    - Third parameter: Class name of content wrapper [string]
 *
 *  NOTE: Separate parameters by space
 *
 *  Example:
 *    <div data-fit-text="19 1200 content-wrapper"> Content goes here </div>
 *
 */

jQuery(window).load(function () {
  fitText();
});

jQuery(document).ready(function() {
  jQuery(window).resize(fitText);
});

var fitTextConstants = new (function() {
  var docMinWidth = 320,
      docMaxWidth = 1920,
      fontMinSize = 10,
      fontMaxSize = 32;

  this.getDocMinWidth = function() { return docMinWidth; };
  this.getDocMaxWidth = function() { return docMaxWidth; };
  this.getFontMinSize = function() { return fontMinSize; };
  this.getFontMaxSize = function() { return fontMaxSize; };
  this.getDocWidthRange = function() { return docMaxWidth - docMinWidth; };
  this.getFontSizeRange = function() { return fontMaxSize - fontMinSize; };
})();

var getDocWidthActualRange = function(docWidth) {
  if (jQuery.isNumeric(docWidth)) {
    var docMaxWidth = docWidth - fitTextConstants.getDocMinWidth();
  }
  else {
    var docMaxWidth = fitTextConstants.getDocWidthRange();
  }
  return docMaxWidth;
};

var getFontRange = function(fontSize) {
  if (jQuery.isNumeric(fontSize)) {
    var fontMaxSize = fontSize - fitTextConstants.getFontMinSize();
  }
  else {
    var fontMaxSize = fitTextConstants.getFontSizeRange();
  }
  return fontMaxSize;
};

var newMathRound = function(number, precision) {
  precision = Math.abs(parseInt(precision)) || 0;
  var coefficient = Math.pow(10, precision);

  return Math.round(number * coefficient) / coefficient;
}

function fitText() {
  var el = jQuery('[data-fit-text]');

  el.each(function(index) {
    var params = jQuery(this).attr('data-fit-text').split(' '),
        fontMaxSize = jQuery.isNumeric(params[0]) ? Math.abs(params[0]) : fitTextConstants.getFontMaxSize(),
        docMaxWidth = jQuery.isNumeric(params[1]) ? Math.abs(params[1]) : fitTextConstants.getDocMaxWidth();
        wrapper = (typeof params[2] == 'string') ? params[2] : null;

    if (typeof wrapper != null) {
      var containerCurrentWidth = jQuery('.' + wrapper).outerWidth();
    }

    var x = 100 - ((containerCurrentWidth - fitTextConstants.getDocMinWidth()) * 100 / getDocWidthActualRange(docMaxWidth)),
        fontSize = newMathRound(fitTextConstants.getFontMinSize() + (getFontRange(fontMaxSize) - (getFontRange(fontMaxSize) * x / 100)), 2);

    jQuery(this).css({ fontSize: fontSize + 'px' });
  });
}
