(function ()
{
    'use strict';

    angular
        .module('app.cruce_data')
        .controller('mongoDataController', mongoDataController);

    /** @ngInject */
    function mongoDataController(URLService, $state, $http, $timeout, localStorageService, $mdDialog, $scope,$document)
    {
        var vm = this;
        vm.url = URLService.url;
        
        // Data
        vm.inspector_selec = 'AGILBERT_21@HOTMSIL.com';
        vm.mongo_id = localStorageService.get('mongo_id');
        vm.mongo_fecha = localStorageService.get('mongo_fecha');
        $scope.mostrar = false;
        inicio();

        // Methods
        vm.atras = atras;

        //////////
        function inicio () {
            var peticion={
            method: 'GET',
            url: vm.url+'/cruceAPI/public/importaciones/'+localStorageService.get('mongo_id')          
           
            }
            $timeout(function() {
                //alert(localStorageService.get('token'));
                $http(peticion).then(function(response) {
                    console.log(response);
                    vm.participaciones=response.data.importaciones_mongo;

                    if(vm.participaciones.length == 0){
                            alert('Sin participaciones');
                    }

                    for (var i = 0; i < vm.participaciones.length; i++) {
                        if(vm.participaciones[i].evento != 'Mongo Mensajes'){
                            vm.participaciones[i].fecha = new Date(vm.participaciones[i].fecha);
                        }
                    }

                    $timeout(function() {
                        $scope.mostrar=true;
                        $scope.$apply();
                    }, 1100);
                    
                    
                                 
                    }, function(response) {
                        console.log(response);
                        //vm.participaciones=response.data.participaciones;

                        $timeout(function() {
                            $scope.mostrar=true;
                            $scope.$apply();
                        }, 1100);

                        if(response.status == 500){
                            alert('Error');
                        }
                    
                    });
            }, 200);
        }

        function atras () {
            $state.go('app.mongo');
        }
        
        
    }
})();