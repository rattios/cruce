(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('inspParaAnularService', inspParaAnularService);

    function inspParaAnularService(URLService, $timeout, localStorageService, $http, $state)
    {
        
        var service = {
            data      : [],
            getInspParaAnular : getInspParaAnular
        };

        function getInspParaAnular(){
            var url = URLService.url;

            var peticion={
                method: 'GET',
                url: url+'/laravelAPI/api/public/inspecciones/validar?token='+localStorageService.get('token'),
                headers: {
                    'Authorization' : 'Bearer ' + localStorageService.get('token')
                }
            }
            $timeout(function() {
                $http(peticion).then(function(response) {
                    console.log(response);
                    var insp = response.data.insp;
                    if(insp.length > 0){
                        for (var i = 0; i < insp.length; i++) {
                            service.data.push(insp[i]);
                        }
                    }

                    }, function(response) {
                        console.log(response);
                      
                    
                    });
            }, 200);
        }
       
        return service;
    }
})();