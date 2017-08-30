(function ()
{
    'use strict';

    angular
        .module('app.dashboards2.project',
            [
                // 3rd Party Dependencies
                'nvd3',
                'datatables',
                'gridshore.c3js.chart',
                'chart.js'
            ]
        )
        .config(config);

    /** @ngInject */
    function config(ChartJsProvider, $stateProvider, msApiProvider)
    {
        // Configure all charts
        ChartJsProvider.setOptions({
          colours: ["#3e95cd", "#8e5ea2"],
          responsive: true
        });

        // State
        $stateProvider.state('app.dashboards_project2', {
            url      : '/cruce-consola',
            views    : {
                'content@app': {
                    templateUrl: 'app/main/cruce_demo/dashboards/project/dashboard-project.html',
                    controller : 'DashboardProjectController2 as vm'
                }
            },
            resolve  : {
                DashboardData: function (msApi)
                {
                    return msApi.resolve('dashboard.project@get');
                }
            },
            bodyClass: 'dashboard-project'
        });

        // Api
        msApiProvider.register('dashboard.project', ['app/data/dashboard/project/data.json']);
    }

})();