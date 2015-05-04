
 (function ($) {
    // here goes your custom code
	//$(".owl-carousel").owlCarousel();
	// Joyride demo
	$('#start-jr').on('click', function() {
	  $(document).foundation('joyride','start');
	});
	jQuery(document).foundation();


}(jQuery));

var gqApp =  angular.module('gqapp', ['iso.directives', 'angularSpinner', 'ui-rangeSlider', 'img-src-ondemand']);
gqApp.controller('singleprodpagecontroller', function ($scope, $sce, getsingle ) {
  //default values
  $scope.currentvariation = {
    var: '',
    vartype: '',
    tax: '',

  };
  $scope.salesprice = '';

    $scope.resetvars = function(){
      $scope.currentvariation = {
        var: '',
        vartype: '',
        tax: '',

      };
    };
    $scope.changevar = function(attname){

        $scope.currentvariation.tax = attname;

        angular.forEach($scope.singledata.available_variations, function(value, key){

          if(value.attributes[attname] === $scope.currentvariation.vartype){
            $scope.currentvariation.var = value;
            //no sales
            if(value.display_regular_price === value.display_price){
              $scope.price      = value.display_regular_price;
              $scope.salesprice = '';
            }else{

              $scope.price      = value.display_price;
              $scope.salesprice = value.display_regular_price;
              $scope.availtext  = value.stock_text;

            }

          }else if($scope.currentvariation.vartype === ''){
            $scope.currentvariation.var = '';

          }

        });


    }
    $scope.to_trusted = function(html_code) {
        return $sce.trustAsHtml(html_code);
    };
    $scope.$watch("postid", function(){
          //Shop loop
          getsingle.getsingle($scope)
          .success(function(data, status, headers, config){
              console.log(data);
              $scope.singledata = data;
              $scope.price = data.price.price;
              if(data.available_variations === 'none'){

                $scope.availtext = data.stock_text;

              }else{


              }
      })
      .error(function(data, status, headers, config) {
        $scope.errormsg = '<h1> refresh the page and try again please.</h1>';

      });
  });

});
gqApp.controller('shoppagecontroller', function ($scope, getshop, $sce, usSpinnerService, $timeout, $location ) {
        // set available range efault this get's overwrote the moment the loop is returned
        $scope.minRing         = 0;
        $scope.maxRing         = 1999;
        $scope.minLength       = 0;
        $scope.maxLength       = 1999;
        // default the user's values to the available range
        $scope.userMinRing     = $scope.minRing;
        $scope.userMaxRing     = $scope.maxRing;
        $scope.userMinLength   = $scope.minLength;
        $scope.userMaxLength   = $scope.maxLength;
        $scope.filters      = '';
        $scope.filtercat    = ' ';


        usSpinnerService.spin('spinner-1');

        $scope.startSpin = function(){
            usSpinnerService.spin('spinner-1');
        }
        $scope.stopSpin = function(){
            usSpinnerService.stop('spinner-1');
        }
        $scope.removeallother = function removeallother(filtercat){

            angular.forEach(angular.element(".filterterms"), function(value, key){
                 var a = angular.element(value);
                 a.removeClass('success');
            });

            angular.forEach(angular.element(".filtercats"), function(value, key){
                 var a = angular.element(value);
                 a.removeClass('success');
            });

            $scope.filtercat = '.'+filtercat;

            $scope.$emit('iso-option', {filter:  $scope.filtercat});

        };

        $scope.limitfunctyion = function limitfunctyion($index){

            if($index > 4 && $index <= 8){
                return true;
            }else{
                return false;
            }

        };

        $scope.showall = function showall(){
            $scope.filters      = '';
            $scope.filtercat    = '';
            // default the user's values to the available range
            $scope.userMinRing     = $scope.minRing;
            $scope.userMaxRing     = $scope.maxRing;
            $scope.userMinLength   = $scope.minLength;
            $scope.userMaxLength   = $scope.maxLength;
            console.log($scope);
            angular.forEach(angular.element(".filterterms"), function(value, key){
                 var a = angular.element(value);
                 a.removeClass('success');
            });

            angular.forEach(angular.element(".filtercats"), function(value, key){
                 var a = angular.element(value);
                 a.removeClass('success');
            });
            $scope.$emit('iso-option', {filter:  '*'});
            $timeout($scope.applyfilter, 300);

        };
        $scope.applyfilter = function(){
            $scope.$emit('iso-option', {filter:  '*'});
        };
        $scope.urlhashedfilter = function(){
          $scope.$emit('iso-option', {filter: $scope.filters});
          angular.forEach()

        };
        $scope.to_trusted = function(html_code) {
            return $sce.trustAsHtml(html_code);
        };

        $scope.$watch('location.url()', function(){

            if($location.url() != ''){
              var geturl       = $location.url().replace('/', '');
              var parseurl     = geturl.replace(/&/g, '.');
              var split        = parseurl.split('.');
              var join         = ' ' + split.join(', .')
              var filters      = join.replace(' , ', '');
              $scope.filters   = filters;
            }else{

              $scope.filters = '';

            }

        });
        $scope.chaindedfilters = function chaindedfilters(filterterm){
            var checkexits = $location.url().indexOf(filterterm);
            if( checkexits === -1){
              $location.url($location.url() + '&' + filterterm);

            }else{
              var parseurl = $location.url().replace('&'+filterterm, '');
              $location.url(parseurl);

            }


            $scope.checkforstringstart = $scope.filters.indexOf(filterterm);
            if($scope.checkforstringstart != -1){

                var checkforstringstart     = $scope.filters.indexOf(", ."+filterterm);
                var checkforstringstarttwo  = $scope.filters.indexOf(" , ."+filterterm);
                var checkforstringstartthr  = $scope.filters.indexOf("."+filterterm+",");


                if(checkforstringstart != -1){
                  $scope.filters = $scope.filters.replace(", ."+filterterm, "");
                }else if(checkforstringstarttwo != -1){
                  $scope.filters = $scope.filters.replace(" , ."+filterterm, "");
                }else if(checkforstringstartthr != -1){
                  $scope.filters = $scope.filters.replace(" ."+filterterm + ", ", "");
                }else{
                  $scope.filters = $scope.filters.replace("."+filterterm, "");

                }




                if($scope.filters.length == 0){
                    $scope.$emit('iso-option', {filter:  '*'});
                }else{
                    $scope.$emit('iso-option', {filter:  $scope.filters});
                }


            }else{
                $scope.filters = $scope.filtercat + $scope.filters + ', .'+ filterterm +'' ;
                $scope.filters = $scope.filters.replace(' , ', '');
                $scope.$emit('iso-option', {filter:  $scope.filters});
            }

        };
        $scope.$watchCollection('[userMaxRing, userMinRing, userMaxLength, userMinLength]', function(){
            $scope.$emit('iso-option', {filter:  '*'});
        });

            //Shop loop
        getshop.getshop($scope)
            .success(function(data, status, headers, config){
                $scope.shoploop = data;
                //console.log(data);
                usSpinnerService.stop('spinner-1');
                if($scope.filters == ''){
                  $timeout($scope.applyfilter, 50);

                }else{

                  $timeout($scope.urlhashedfilter, 100);

                }

        })
        .error(function(data, status, headers, config) {
          $scope.errormsg = '<h1> refresh the page and try again please.</h1>';

    });
		//watch category input
	    $scope.$watch("category", function(){



		});
});
gqApp.factory('getshop', function($http){
    return {
        getshop: function($scope) {
            return  $http({
                        method: 'POST',
                        url: '/wp-admin/admin-ajax.php',
                        data: $scope.category,
                        params: { 'action': 'shop_page_loop', }
                    });
        }
    };
});
gqApp.factory('getsingle', function($http){
    return {
        getsingle: function($scope) {
            return  $http({
                        method: 'POST',
                        url: '/wp-admin/admin-ajax.php',
                        data: $scope.postid,
                        params: { 'action': 'single_page', }
                    });
        }
    };
});
gqApp.factory('childcatsfilterService', ['$filter', function($filter) {
  return function(data) {
    return $filter('childcatsfilter')(data);
  };
}]);
gqApp.factory('getcatsparent', function($http) {
    return {
        getcatsparent: function(){
            return  $http({
                        method: 'GET',
                        url: '/wp-admin/admin-ajax.php',
                        params: { 'action': 'cats_loop'}
                    });
        }

    };
});
gqApp.factory('getcatschild', function($http) {
    return {
        getcatschild: function(){
            return  $http({
                        method: 'GET',
                        url: '/wp-admin/admin-ajax.php',
                        data: $scope,
                        params: { 'action': 'cats_child_loop' }
                    });
        }

    };
});
gqApp.factory('getcatsparent', function($http) {
    return {
        getcatsparent: function(){
            return  $http({
                        method: 'GET',
                        url: '/wp-admin/admin-ajax.php',
                        params: { 'action': 'cats_loop'}
                    });
        }

    };
});
/**Filters**/
gqApp.filter("minmaxfilter", function() {
  return function(items, from, to, title) {
        var from = parseInt(from);
        var to = parseInt(to);
        var result = [];
        angular.forEach(items, function(value, key){
            if(value.ring_gauge != "NULL"){
                var price = parseInt(value.ring_gauge);
                if(price >= from && price <= to){
                    result.push(value);
                }
            }else{
                result.push(value);
            }
        });

        return result;
  };
});
//Used for slider on selling listings loop
gqApp.filter("fractionit", function() {
  return function(numb) {
    //var Fraction = require('fractional').Fraction;
            function fraction(numb){
                var numb        = numb.toString();
                var getpredec   = numb.split(".");
                var getdecimal  = parseFloat( "0." + getpredec[1] );
                var frac        = getdecimal;
                var returnvalue = frac * 8;
                var concat      = returnvalue.toString() + "/8";
                return concat;
            }
            var returnfac = "numb";
            var numb        = numb.toString();
            var getpredec   = numb.split(".");
            if(getpredec.length > 1){

                    var returnfac   = getpredec[0] + " " + fraction(numb) + '"';
                    return returnfac;
                }else{
                    return numb + '"';
                }

  };
});
gqApp.filter("minmaxfilterlength", function() {
  return function(items, from, to, title) {
        var from = parseInt(from);
        var to = parseInt(to);
        var result = [];
        angular.forEach(items, function(value, key){
            if(value.cigar_length != "NULL"){
                var price = parseInt(value.cigar_length);
                if(price >= from && price <= to){
                    result.push(value);
                }
            }else{
                    result.push(value);

            }
        });

        return result;
  };
});
/**Directive*/
gqApp.directive("markable", function() {
    return {
        link: function(scope, elem, attrs) {
            elem.on("click", function() {
                if(elem.hasClass('success')){
                    elem.removeClass("success");
                }else{
                    elem.addClass("success");
                }
            });
        }
    };
});

gqApp.directive('filterterms',['$location', function(location){
    // Runs during compile
    return {
        restrict: 'C', // E = Element, A = Attribute, C = Class, M = Comment
        link: function($scope, iElm, iAttrs, controller) {
                    // DO SOMETHING
            var geturl       = location.url().replace('/', '');
            var parseurl     = geturl.split('&');
            angular.forEach(parseurl, function(value, key){
              if(value != ""){

                  var checkclass   = iElm.context.className.indexOf(value);

                  if(checkclass > -1){

                    iElm.addClass('success');

                  }
              }

            });


        }
    };
}]);
/**Config*/
gqApp.config(['usSpinnerConfigProvider', function (usSpinnerConfigProvider) {
    usSpinnerConfigProvider.setDefaults({
              lines: 13, // The number of lines to draw
              length: 24, // The length of each line
              width: 7, // The line thickness
              radius: 30, // The radius of the inner circle
              corners: 1, // Corner roundness (0..1)
              rotate: 17, // The rotation offset
              direction: 1, // 1: clockwise, -1: counterclockwise
              color: '#000', // #rgb or #rrggbb or array of colors
              speed: 1, // Rounds per second
              trail: 74, // Afterglow percentage
              shadow: false, // Whether to render a shadow
              hwaccel: false, // Whether to use hardware acceleration
              top: '50%', // Top position relative to parent
              left: '50%' // Left position relative to parent
    });
}]);
gqApp.config(['ImgSrcOndemandProvider', function(ImgSrcOndemandProvider) {
  ImgSrcOndemandProvider.offset(100);
}]);
