(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('URLService', URLService);

    function URLService()
    {
        //--> http://tecprecincsrl.com.ar
        //--> http://localhost
        var service = {
            url         : 'http://vivomedia.com.ar/vivoindex'
        };
       
        return service;
    }
})();