(function ()
{
    'use strict';

    angular
        .module('fuse')
        .factory('menuService', menuService);

    function menuService(msNavigationService)
    {
        
        var service = {
            
            generarMenu : generarMenu,
            borrarItem : borrarItem
        };

        function generarMenu(){
			//Menu 
			msNavigationService.saveItem('consola', {
			  title    : 'Consola',
			  icon     : 'icon-tile-four',
			  state    : 'app.consola',
			  weight   : 1
			});

			msNavigationService.saveItem('inspecciones', {
			  title : 'Programa de Inspecciones',
			  icon  : 'icon-clipboard-text',
			  weight: 2
			});

			msNavigationService.saveItem('inspecciones.programar_inspeccion', {
			  title: 'Programar Inspeccion',
			  state: 'app.programar_inspeccion'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion', {
			  title: 'Ver agenda de Inspecciones',
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.encurso', {
			  title: 'Ver En Curso',
			  state: 'app.ver_inspeccion_curso'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.asignados', {
			  title: 'Ver Asignadas',
			  state: 'app.ver_inspeccion_asignados'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.noasignados', {
			  title: 'Ver No Asignadas',
			  state: 'app.ver_inspeccion_noasignados'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.ejecutadas', {
			  title: 'Ver Ejecutadas',
			  state: 'app.ver_inspeccion_ejecutada'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.bloqueadasAsignadas', {
			  title: 'Ver Bloq/Asig',
			  state: 'app.ver_inspeccion_bloqueadasAsignadas'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.bloqueadas', {
			  title: 'Ver Bloqueadas',
			  state: 'app.ver_inspeccion_bloqueadas'
			});

			msNavigationService.saveItem('inspecciones.ver_inspeccion.anuladas', {
			  title: 'Ver Anuladas',
			  state: 'app.ver_inspeccion_anuladas'
			});

			msNavigationService.saveItem('inspecciones.programa_anual', {
			  title: 'Programa Anual',
			  //state: 'app.programa_anual'
			});

			msNavigationService.saveItem('inspecciones.programa_anual.y-sur', {
			  title: 'Y-SUR',
			  state: 'app.programa_anual_y-sur'
			});

			msNavigationService.saveItem('inspecciones.programa_anual.ypf_rdls', {
			  title: 'YPF RDLS',
			  state: 'app.programa_anual_ypf_rdls'
			});

			msNavigationService.saveItem('inspecciones.programa_anual.ypf_sa-ciph', {
			  title: 'YPF SA-CIPH',
			  state: 'app.programa_anual_ypf_sa-ciph'
			});

			msNavigationService.saveItem('inspecciones.programa_anual.ypf_sa-unng', {
			  title: 'YPF SA-UNNG',
			  state: 'app.programa_anual_ypf_sa-unng'
			});

			msNavigationService.saveItem('inspectores', {
			  title : 'Operarios',
			  icon  : 'icon-account-multiple',
			  weight: 3
			});

			msNavigationService.saveItem('inspectores.ver_inspectores', {
			  title: 'Ver agenda de Operarios',
			  state: 'app.ver_inspectores'
			});

			msNavigationService.saveItem('inspectores.historial_inspectores', {
			  title: 'Historial de Operarios',
			  state: 'app.historial_inspectores'
			});

			msNavigationService.saveItem('inspectores.administrar_inspectores', {
			  title: 'Administrar Operarios',
			  state: 'app.administrar_inspectores'
			});

			msNavigationService.saveItem('reportes', {
			  title    : 'Reportes',
			  icon     : 'icon-file-document',
			  weight   : 4
			});

			msNavigationService.saveItem('reportes.reporte_remito', {
			  title: 'Reporte de inspección',
			  state: 'app.reporte_remito'
			});

			msNavigationService.saveItem('c_programa_anual', {
			  title    : 'Programa Anual',
			  icon     : 'icon-table-large',
			  state    : 'app.c_programa_anual',
			  weight   : 5
			});

			msNavigationService.saveItem('c_reporte_remito', {
			  title    : 'Reportes',
			  icon     : 'icon-file-document',
			  state    : 'app.c_reporte_remito',
			  weight   : 6
			});

			msNavigationService.saveItem('usuarios', {
			  title    : 'Usuarios',
			  icon     : 'icon-account-box',
			  state    : 'app.usuarios',
			  weight   : 7
			});
        }

        function borrarItem (item) {
        	msNavigationService.deleteItem(item);
        }
       
        return service;
    }
})();