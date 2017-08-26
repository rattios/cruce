(function ()
{
    'use strict';

    angular
        .module('app.cruce_clientes.clientes', [
            'datatables',
            'nvd3',
            'flow',
            'textAngular',
            'uiGmapgoogle-maps',
            'xeditable'
            ])
        .config(config);

    /** @ngInject */
    function config($stateProvider, $translatePartialLoaderProvider, msApiProvider, msNavigationServiceProvider)
    {
        // State
        $stateProvider
            .state('app.clientes', {
                url    : '/clientes',
                views  : {
                    'content@app': {
                        templateUrl: 'app/main/cruce_clientes/cruce_clientes.html',
                        controller : 'cruce_clientesController as vm'
                    }
                }/*,
                resolve: {
                    SampleData: function (msApi)
                    {
                        return msApi.resolve('inspectores.ver_inspectores@get');
                    }
                }*/
            })
            .state('app.participaciones', {
                url    : '/clientes/participaciones',
                views  : {
                    'content@app': {
                        templateUrl: 'app/main/cruce_clientes/participaciones_cliente/participaciones_cliente.html',
                        controller : 'participaciones_clienteController as vm'
                    }
                }
            });

        // Translation
        //$translatePartialLoaderProvider.addPart('app/main/sample');

        // Api
        //msApiProvider.register('inspectores.ver_inspectores', ['app/data/sample/sample.json']);

        // Navigation
        msNavigationServiceProvider.saveItem('cruce', {
            title : 'CRUCE',
            group : true,
            weight: 5
        });

        msNavigationServiceProvider.saveItem('cruce.clientes', {
            title: 'Clientes',
            icon  : 'icon-account-multiple',
            state: 'app.clientes'
        });
    }
})();