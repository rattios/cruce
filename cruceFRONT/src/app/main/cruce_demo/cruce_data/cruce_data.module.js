(function ()
{
    'use strict';

    angular
        .module('app.cruce_data',
            [
                'datatables',
	            'nvd3',
	            'flow',
	            'textAngular',
	            'xeditable'
            ]
        )
        .config(config);

    /** @ngInject */
    function config(msNavigationServiceProvider, $stateProvider)
    {

    	// State
        $stateProvider
            .state('app.mongo', {
                url      : '/mongo',
                views    : {
                    'content@app': {
                        templateUrl: 'app/main/cruce_demo/cruce_data/vistas/mongo/mongo.html',
                        controller : 'mongoController as vm'
                    }
                }
            })
            .state('app.mongo_data', {
                url      : '/mongo/data',
                views    : {
                    'content@app': {
                        templateUrl: 'app/main/cruce_demo/cruce_data/vistas/mongo/data/mongo_data.html',
                        controller : 'mongoDataController as vm'
                    }
                }
            });
            

        // Navigation
        msNavigationServiceProvider.saveItem('cruce.cruce_data', {
            title : 'Importaciones',
            icon  : 'icon-import',
            weight: 3
        });

        msNavigationServiceProvider.saveItem('cruce.cruce_data.mongo', {
            title: 'Mongo',
            icon: 'icon-content-save-all',
            state: 'app.mongo'
        });

    }

})();