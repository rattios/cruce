(function ()
{
    'use strict';

    angular
        .module('app.cruce_clientes.clientes')
        .controller('cruce_clientesController', cruce_clientesController);

    /** @ngInject */
    function cruce_clientesController( URLService, $state, $http, $timeout, localStorageService, $mdDialog, $scope,$document)
    {
        var vm = this;
        vm.url = URLService.url;

        // Data
        //vm.helloText = SampleData.data.helloText;
        //vm.inspectores = inspectores;
        $scope.mostrar = false;
        inicio ();

        // Methods
        vm.verAgenda = verAgenda;


        function inicio () {
            var peticion={
            method: 'GET',
            url: vm.url+'/cruceAPI/public/lista/clientes'
            }
            $timeout(function() {
                $http(peticion).then(function(response) {
                    console.log(response);
                    vm.inspectores=response.data.clientes;
                    
                    $timeout(function() {
                        $scope.mostrar=true;
                        $scope.$apply();
                    }, 1100);
       
                    }, function(response) {
                        console.log(response);

                        $timeout(function() {
                                $scope.mostrar=true;
                                $scope.$apply();
                        }, 1100);
                    });
            }, 200);
        }
          

        vm.dtInstance = {};
        vm.dtOptions = {
            dom         : 'rt<"bottom"<"left"<"length"l>><"right"<"info"i><"pagination"p>>>',
            columnDefs  : [
                {
                    // Target the id column
                    targets: 0
                    //width  : '72px'
                },
                {
                    // Target the actions column
                    targets           : 5,
                    responsivePriority: 1,
                    filterable        : false,
                    sortable          : false,
                    width  : '72px'
                }
            ],
            initComplete: function ()
            {
                var api = this.api(),
                    searchBox = angular.element('body').find('#e-commerce-products-search');

                // Bind an external input as a table wide search box
                if ( searchBox.length > 0 )
                {
                    searchBox.on('keyup', function (event)
                    {
                        api.search(event.target.value).draw();
                    });
                }
            },
            pagingType  : 'simple',
            lengthMenu  : [10, 20, 30, 50, 100],
            pageLength  : 20,
            scrollY     : 'auto',
            responsive  : true
        };      

        //////////
        function verAgenda(email){
            localStorageService.set('cliente_email', email);
            $state.go('app.participaciones');
        }





    }
})();
