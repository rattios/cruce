(function ()
{
    'use strict';

    angular
        .module('fuse')
        .directive('loading2', loading2);

    function loading2()
    {
        return {
            restrict: 'E',
            replace:true,
            template: '<div class="loading2"><img src="/assets/images/logos/spina.svg" width="40" height="40"/></div>',
            link: function (scope, element, attr) {
                  scope.$watch('loading2', function (val) {
                      if (val)
                          $(element).show();
                      else
                          $(element).hide();
                  });
            }
          }
    }
})();

