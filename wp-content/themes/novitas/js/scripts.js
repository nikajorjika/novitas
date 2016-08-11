/*
*
* default Functionality
*
* By HBtech
*
*
* */
 (function($){

	 var initFlexSlider = function () {
		 $('.flexslider').flexslider({
			 animation: "slide",
			 slideshowSpeed: 4000,
		 });
	 };
	 var initCustomScrollBar = function () {
		 $(".mCustomScrollbar").mCustomScrollbar({
			 theme:'unimed-theme'
		 });
	 };
	 var onInit = function () {

		 console.log('on init function executed');

		 $('.dotdotdot').dotdotdot();
		 $('.news-content').dotdotdot();
		 $('.medicaments-content').dotdotdot();

		 $('.item-content-container').dotdotdot();

	 };
	 var onResize = function () {
		 $(window).on('resize', function () {

			 $('.news-content').dotdotdot();
			 $('.medicaments-content').dotdotdot();

			 $('.item-content-container').dotdotdot();
		 });
	 };
	 var makeSliders = function () {

		 $(".fancybox").fancybox({
			 width: "80%",
			 height: "auto",
			 padding: 0,
			 prevEffect: 'fade',
			 nextEffect: 'fade',
			 closeBtn: false
		 });
		 $(".videos").click(function() {
			 $.fancybox({
				 'padding'		: 0,
				 'autoScale'		: false,
				 'transitionIn'	: 'none',
				 'transitionOut'	: 'none',
				 'title'			: this.title,
				 'width'			: 640,
				 'height'		: 385,
				 'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				 'type'			: 'swf',
				 'swf'			: {
					 'wmode'				: 'transparent',
					 'allowfullscreen'	: 'true'
				 }
			 });
			 return false;
		 });
	 };
	 var hamburgerToggle = function(){
		 $('#nav-icon1').click(function(){
			 $(this).toggleClass('open');
			 $('.menu-content').fadeToggle();
			 $('body').toggleClass('overflow-hidden');
		 });
	 }
	 var toggleSearch = function(){
		 $('.search-toggle').click(function() {
			 $('.search-container').toggleClass('active');
		 });
	 }
	 $(window).load(function () {
		 initFlexSlider();
		 makeSliders();
		 onResize();
		 onInit();
		 hamburgerToggle();
		 toggleSearch();
		 initCustomScrollBar();
		 $('.switcher').taber('.switcher', '.tab');

	 });
	setTimeout(function() {
		$('input').focus(function() {
			$(this).closest('form').addClass('focused');
		}).focusout(function () {
			if ( ! $(this).val()) {
				$(this).closest('form').removeClass('focused');
			}
		});
	}, 1);
	setTimeout(function() {
		$('.home input').focus(function() {
			$('.opacity-div').addClass('opacity');
		}).focusout(function () {
			if ( ! $(this).val()) {
				$('.opacity-div').removeClass('opacity');
			}
		});
	}, 1);
 })(jQuery);