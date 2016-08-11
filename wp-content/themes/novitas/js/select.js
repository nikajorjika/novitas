(function($){
    var medicamentMarkup = function (title,content,image_url,post_url){
        var markup = '<div class="medicaments">' +
            '<div class="medicaments-image"'+
        'style="background-image: url('+ image_url +');'+
        'background-size: cover;'+
        'background-position: center center;'+
        'background-repeat: no-repeat;">'+
        '</div>'+
        '<div class="medicaments-content-wrapper">'+
            '<div class="medicaments-header">'+
        '<h1>'+ title +'</h1>'+
        '</div>'+
        '<div class="medicaments-content">'+
        content+
        '</div>'+
        '<div class="medicaments-more">' +
            '<a href="'+ post_url +'">' +
                'ვრცლად' +
            '</a></div></div></div>';
        return markup;
    };
    $(window).load(function () {
        $('#medicament_category').on('change', function () {
            $('.medicaments-main-container').append('<div id="loader"></div>');
            var currentOption = $(this).find(':selected')[0];
            var security = localizedVars.security;
            var data = {
              term : $(currentOption).val()
            };
            $('.medicaments-container').html('');
            var successCallback = function (response) {
                response.forEach(function (item) {
                    var markup = medicamentMarkup(item.title, item.content, item.image, item.url);
                    $('.medicaments-container').append(markup);
                });
                $('.medicaments-content').dotdotdot();
                $('#loader').remove();
            };
            ajaxLoadHandler('get_by_term', security, data,successCallback,'json');
        });

        $('.med-categories').find('.med-categories-ul li').on('click', function () {
            $('.medicaments-main-container').append('<div id="loader"></div>');

            var security = localizedVars.security;
            var data = {
              term : $(this).data('id')
            };

            $('.medicaments-container').html('');

            var successCallback = function (response) {
                response.forEach(function (item) {
                    var markup = medicamentMarkup(item.title, item.content, item.image, item.url);
                    $('.medicaments-container').append(markup);
                });
                $('.medicaments-content').dotdotdot();
                $('#loader').remove();
            };

            ajaxLoadHandler('get_by_term', security, data,successCallback,'json');

            $('.med-categories').find('.med-categories-ul li.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    });
})(jQuery);