import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';

import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';

const routes: Routes = [{
  path: '',
  component: PagesComponent,
  children: [{
    path: 'dashboard',
    component: DashboardComponent,
  },
   {
    path: 'ui-features',
    loadChildren: './ui-features/ui-features.module#UiFeaturesModule',
  }, {
    path: 'components',
    loadChildren: './components/components.module#ComponentsModule',
  }, {
    path: 'maps',
    loadChildren: './maps/maps.module#MapsModule',
  }, {
    path: 'charts',
    loadChildren: './charts/charts.module#ChartsModule',
  }, {
    path: 'editors',
    loadChildren: './editors/editors.module#EditorsModule',
  }, {
    path: 'forms',
    loadChildren: './forms/forms.module#FormsModule',
  },{
    path: 'tables',
    loadChildren: './tables/tables.module#TablesModule',
  },{
    path: 'socios',
    loadChildren: './socios/socios.module#SociosModule',
  },
  {
    path: 'clientes',
    loadChildren: './clientes/clientes.module#ClientesModule',
  },{
    path: 'lu5',
    loadChildren: './lu5/lu5.module#Lu5Module',
  },{
    path: 'subcategorias',
    loadChildren: './subcategorias/subcategorias.module#SubcategoriasModule',
  },{
    path: 'productos',
    loadChildren: './productos/productos.module#ProductosModule',
  },{
    path: 'establecimientos',
    loadChildren: './establecimientos/establecimientos.module#EstablecimientosModule',
  },{
    path: '',
    redirectTo: 'dashboard',
    pathMatch: 'full',
  }],
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PagesRoutingModule {
}
