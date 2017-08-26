(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('notificacionService', notificacionService);

    function notificacionService($http)
    {
        //--> http://tecprecincsrl.com.ar
        //--> http://localhost
        var service = {
            notificacion: notificacion
        };

        /*Funcion para enviar notificacion,
        la paso el id del operador al cual le quiero 
        enviar la notificacion y el mensaje*/
        function notificacion(id,mensaje){
            var peticion={
                    method: 'POST',
                    url: 'http://tecprecincsrl.com.ar/inspecciones/push.php?id='+id+'&mensaje='+mensaje
                }
                
                    $http(peticion).
                    then(function(response) {

                        console.log(response);
                        console.log('notificacion exito '+peticion.url);
                    }, function(response) {
             
                        console.log(response);
                        console.log('notificacion error '+peticion.url);
                    });
                
        }
       
        return service;
    }
})();