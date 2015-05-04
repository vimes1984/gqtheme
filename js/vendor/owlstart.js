(function ($) {

   var owl = $("#owl-demo");

   owl.owlCarousel({
       items : 4, //10 items above 1000px browser width
       itemsDesktop : [1000,5], //5 items between 1000px and 901px
       itemsDesktopSmall : [900,3], // betweem 900px and 601px
       itemsTablet: [600,2], //2 items between 600 and 0
       autoPlay: 8000, //Set AutoPlay to 3 seconds
       itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
   });


}(jQuery));
