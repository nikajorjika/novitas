function contactForm(e) {
  e.preventDefault();

  var emptyField = false;

  // Check if fields is empty
  jQuery('#ka-contact-form input').each(function() {
    if (jQuery(this).val() == '') {
      emptyField = true;
    }
  });

  // If fields is empty, show fill all the fields message
  if (emptyField) {
    jQuery('.mail-message').text(localizeData.fillAllFields).show();

    setTimeout(function() {
      jQuery('.mail-message').hide();
    }, 5000);

    return;
  }

  // else collect form data and send e-mail
  var data = {
    email: jQuery('#ka-email').val(),
    msg: jQuery('#ka-message').val()
  },
  security = localizedVars.security;

  // Callback on success
  var successFunction = function(response) {
    jQuery('.mail-message').text(localizeData.messageSent).show();

    setTimeout(function() {
      jQuery('.mail-message').hide();
    }, 5000);

    return;
  };

  // Make AJAX call
  ajaxLoadHandler('contact_form', security, data, successFunction, 'json');
}
