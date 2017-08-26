(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('Excel', Excel);

    function Excel($window)
    {
      var uri='data:application/vnd.ms-excel;base64,',
      template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><style>table{display:inline-block;page-break-after:auto;border-collapse: collapse;border-width: 1px 0 0 0px !important;}td,th{border: 1px solid #000 !important;}</style></head><body><table>{table}</table></body></html>',
      base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
      format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
      return {
        tableToExcel:function(tableId,worksheetName){
          var table=$(tableId),
            ctx={worksheet:worksheetName,table:table.html()},
            href=uri+base64(format(template,ctx));
          return href;
        }
      };
    }
})();