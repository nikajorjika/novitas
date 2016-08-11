(function ($) {

    $.fn.taber =function( tabSelector ){
        var selector = this;
        selector.each(function(){
            var item = $(this);
            if(item.hasClass('active')){
                $('.tab').hide();
                var tabIdentifier = item.attr('data-target');
                $('.tab[data-id='+ tabIdentifier +']').fadeIn().addClass('active');
            }
        });
        $(this).on('click', function () {
            var clickedObject = $(this);
            if(clickedObject.hasClass('active')){
                return;
            }
            selector.removeClass('active');
            clickedObject.addClass('active');


            var tabIdentifier = clickedObject.attr('data-target');
            $('.tab.active').hide().removeClass('active');
            $('.tab[data-id='+ tabIdentifier +']').fadeIn().addClass('active');

        });
    }

})(jQuery);