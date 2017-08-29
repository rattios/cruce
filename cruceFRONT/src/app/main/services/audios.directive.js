(function ()
{
    'use strict';

    angular
        .module('fuse')
        .directive('audios', audios);

    function audios($sce)
    {
        return {
	    	restrict: 'A',
		    scope: { code:'=' },
		    replace: true,
		    template: '<audio ng-src="{{url}}" controls></audio>',
		    link: function (scope) {
		        scope.$watch('code', function (newVal, oldVal) {
		           if (newVal !== undefined) {
		               scope.url = $sce.trustAsResourceUrl(newVal);
		           }
		        });
		    }
		}
    }
})();