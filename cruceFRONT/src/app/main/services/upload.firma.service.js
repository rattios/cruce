(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('upload', upload);

    function upload(URLService, $timeout, localStorageService, $http, $q)
    {
        
        var service = {
            uploadFile : uploadFile
        };

        function uploadFile(file, name){
            var url = URLService.url;

            var deferred = $q.defer();
			var formData = new FormData();
			formData.append("name", name);
			formData.append("file", file);

			
            //$timeout(function() {
                $http.post(url+"/laravelAPI/server.php?name="+name, formData, {
				headers: {
					"Content-type": undefined
				},
				transformRequest: angular.identity
				}).then(function(response) {
	                    console.log(response);
	            }, function(response) {
	                console.log(response);
	             
            });
            //}, 200);
        }
       
        return service;
    }
})();
