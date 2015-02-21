
 (function ($) {
    // here goes your custom code
	//$(".owl-carousel").owlCarousel();
	console.log($);
	// Joyride demo
	$('#start-jr').on('click', function() {
	  $(document).foundation('joyride','start');
	});
	jQuery(document).foundation();
}(jQuery));

var gqApp =  angular.module('gqapp', ['iso.directives', 'angularSpinner', 'ui-rangeSlider']);
gqApp.controller('shoppagecontroller', function ($scope, getshop, $sce, usSpinnerService, $timeout ) {
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
        $scope.filtercat    = '';
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

            if($index > 3 && $index <= 7){
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
        $scope.to_trusted = function(html_code) {
            return $sce.trustAsHtml(html_code);
        };

        $scope.chaindedfilters = function chaindedfilters(filterterm){
            
            $scope.checkforstringstart = $scope.filters.indexOf(filterterm);
            if($scope.checkforstringstart != -1){
                
                $scope.filters = $scope.filters.replace("."+filterterm, "");                

                if($scope.filters.length == 0){
                    $scope.$emit('iso-option', {filter:  '*'});
                }else{
                    $scope.$emit('iso-option', {filter:  $scope.filters});
                }


            }else{
                $scope.filters = $scope.filtercat + $scope.filters + '.'+ filterterm +'' ;
                $scope.$emit('iso-option', {filter:  $scope.filters});
            }

        };
        $scope.$watchCollection('[userMaxRing, userMinRing, userMaxLength, userMinLength]', function(){
            $scope.$emit('iso-option', {filter:  '*'});
        });

		//watch category input
	    $scope.$watch("category", function(){
            //Shop loop
            getshop.getshop($scope)
                .success(function(data, status, headers, config){
                    $scope.shoploop = data;

                    usSpinnerService.stop('spinner-1');
                    $timeout($scope.applyfilter, 500);

                    console.log(data);
            
		        })
		        .error(function(data, status, headers, config) {
				    alert('UUUUUU YOU BROKE IT!!! refresh the page and try again please.');
				});
            $scope.$emit('iso-option', {filter:  '*'});
		
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