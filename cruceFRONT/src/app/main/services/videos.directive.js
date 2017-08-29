(function ()
{
    'use strict';

    angular
        .module('fuse')
        .directive('videos', videos);

    function videos($sce)
    {
        return {
	    	restrict: 'A',
		    scope: { code:'=' },
		    replace: true,
		    /*template: '<audio ng-src="{{url}}" controls preload="none"></audio>',*/
		    template: '<video width="400" height="300" src="{{url}}" controls="controls" preload="none" poster="https://lh3.googleusercontent.com/6iGgUOxEhyyLW1HuSCB5LP0_WANtNiZjftQDt8pQCy1E2fxyP9fLVr6y9K5sPK0RFQ=w300">Tu navegador no admite el elemento <code>video</code>.</video>',
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