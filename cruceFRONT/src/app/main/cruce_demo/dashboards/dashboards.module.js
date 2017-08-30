(function ()
{
    'use strict';

    angular
        .module('app.dashboards2',
            [
                'app.dashboards2.project'
            ]
        )
        .config(config);

    /** @ngInject */
    function config(msNavigationServiceProvider)
    {
        // Navigation
        msNavigationServiceProvider.saveItem('cruce', {
            title : 'CRUCE',
            group : true,
            weight: 5
        });

        msNavigationServiceProvider.saveItem('cruce.project', {
            title: 'Consola',
            icon  : 'icon-tile-four',
            state: 'app.dashboards_project2',
            weight: 1
        });

    }

})();