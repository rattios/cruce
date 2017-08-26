(function ()
{
    'use strict';

    angular
        .module('fuse')
        .directive('loadingl', loadingl);

    function loadingl()
    {
        return {
            restrict: 'E',
            replace:true,
            template: '<div class="loading"><img src="/assets/images/logos/spina.svg" width="50" height="50"/></div>',
            link: function (scope, element, attr) {
                  scope.$watch('loading', function (val) {
                      if (val)
                          $(element).show();
                      else
                          $(element).hide();
                  });
            }
          }
    }

})();

