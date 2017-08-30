(function ()
{
    'use strict';

    angular.module('app.cruce_clientes.clientes')
        .controller('participaciones_clienteController', participaciones_clienteController);

    /** @ngInject */
    function participaciones_clienteController(Cards, URLService, Excel, $state, $scope, $document, $mdDialog, $http, $timeout, localStorageService, $filter)
    {
        var vm = this;
        vm.url = URLService.url;

        vm.cards = Cards.data;

        // Data
        vm.agenda = agenda;
        vm.inspector_selec = localStorageService.get('cliente_email');

        $scope.mostrar = false;


        // Methods
        vm.atras = atras;

        //////////

        var agenda={
            method: 'GET',
            url: vm.url+'/cruceAPI/public/clientes/participaciones/'+localStorageService.get('cliente_email')            
           
        }
        $timeout(function() {
            //alert(localStorageService.get('token'));
            $http(agenda).then(function(response) {
                console.log(response);
                vm.participaciones=response.data.participaciones;

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


        function atras () {
            $state.go('app.clientes');
        }



    }
})();