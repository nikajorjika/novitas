(function($){
    var appendSuggestion = function (item) {
        if(item.title != undefined){
            var ul =  $('#med-search-form .suggestions-container ul');
            var appendLists = '<a href="' + item.url + '"><li>'+ item.title + '</li></a>';
            ul.append(appendLists);
        }
    };
    $(window).load(function () {
        var inputTimeOut = null;

        $('#med-search-input').click( function (event ) {

        });
        $('#med-search-input').blur( function (event ) {
            if($(event.relatedTarget).attr('href') == undefined || $(event.relatedTarget).attr('href').length == 0 ){
                $('#med-search-form .suggestions-container').css('display','none');
            }
        });
        $('#med-search-input').focus( function (event ) {
            $('#med-search-form .suggestions-container').css('display','block');
        });
        $('#med-search-input').keyup( function (event ) {
            if (inputTimeOut != null) {
                clearTimeout(inputTimeOut);
            }

            $('#med-search-form .suggestions-container').html('<div id="loader" class="small"></div><ul></ul>');
            $('#med-search-form .suggestions-container').height('100px');

            var data = {
                q: $(this).val()
            };

            var successCallback = function (response) {
                if(response.length == 0) {
                    appendSuggestion(0);
                    //return;
                }

                response.forEach(function (item) {
                    appendSuggestion(item);
                });

                $('#loader').remove();
                $('#med-search-form .suggestions-container').height('auto');
            };

            if($('#med-search-input').val().length != 0) {
                inputTimeOut = setTimeout(function() {
                    $('#med-search-form .suggestions-container').html('<div id="loader" class="small"></div><ul></ul>');
                    $('#med-search-form .suggestions-container').height('100px');
                    ajaxLoadHandler('get_search_items', '', data, successCallback, 'json');
                }, 200);
            } else {
                $('#loader').remove();
                $('#med-search-form .suggestions-container').height('auto');
            }
        })
    })
})(jQuery);