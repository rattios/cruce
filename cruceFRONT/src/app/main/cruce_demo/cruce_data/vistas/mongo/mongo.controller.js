(function ()
{
    'use strict';

    angular
        .module('app.cruce_data')
        .controller('mongoController', mongoController);

    /** @ngInject */
    function mongoController(URLService, $state, $http, $timeout, localStorageService, $mdDialog, $scope,$document)
    {
        var vm = this;
        vm.url = URLService.url;
        
		$scope.mostrar = false;
        inicio();

        // Methods
        vm.verAgenda = verAgenda;
        vm.actualizar = actualizar;

        function inicio () {
            var peticion={
            method: 'GET',
            url: vm.url+'/cruceAPI/public/importaciones'
            }
            $timeout(function() {
                $http(peticion).then(function(response) {
                    console.log(response);
                    vm.inspectores=response.data.importaciones_mongo;

                    vm.ultimaImportacion = vm.inspectores[0].fecha;
                    
                    $timeout(function() {
                        $scope.mostrar=true;
                        $scope.$apply();
                    }, 1100);
       
                    }, function(response) {
                        console.log(response);

                        if(response.status == 404){
                            $scope.mostrar=true;
                            vm.inspectores = [];
                            vm.ultimaImportacion = '0000-00-00 00:00:00';
                            alert(response.data.error);                       
                        }

                        
                    });
            }, 200);
        }

        vm.dtInstance = {};
        vm.dtOptions = {
            dom         : 'rt<"bottom"<"left"<"length"l>><"right"<"info"i><"pagination"p>>>',
            columnDefs  : [
                {
                    // Target the id column
                    targets: 0,
                    width  : '8px'
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
        function verAgenda(id, fecha){
            localStorageService.set('mongo_id', id);
            localStorageService.set('mongo_fecha', fecha);
            $state.go('app.mongo_data');
        }

        function actualizar (fechaUltImportacion) {
            $scope.mostrar=false;

            var peticion={
            method: 'POST',
            url: vm.url+'/cruceAPI/public/importar/'+fechaUltImportacion
            }
            $timeout(function() {
                $http(peticion).then(function(response) {
                    console.log(response);
                    vm.inspectores=response.data.importaciones_mongo;

                    vm.ultimaImportacion = vm.inspectores[0].fecha;
                    
                    $timeout(function() {
                        alert(response.data.msg);
                        $scope.mostrar=true;
                        $scope.$apply();
                    }, 1100);
       
                    }, function(response) {
                        console.log(response);

                        if(response.status == 404){
                            $scope.mostrar=true;
                            vm.inspectores = [];
                            vm.ultimaImportacion = '0000-00-00 00:00:00';
                            alert(response.data.error);                       
                        }

                        
                    });
            }, 200);
        }
        
        
    }
})();