import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';

import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ClientesComponent } from './clientes/clientes.component';
import { ImportarComponent } from './importar/importar.component';
import { AgendasComponent } from './agendas/agendas.component';

const routes: Routes = [{
  path: '',
  component: PagesComponent,
  children: [{
    path: 'dashboard',
    component: DashboardComponent,
  },{
    path: 'importar',
    component: ImportarComponent,
  },{
    path: 'agendas',
    component: AgendasComponent,
  },{
    path: 'ui-features',
    loadChildren: './ui-features/ui-features.module#UiFeaturesModule',
  },{
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
    path: 'lu5',
    loadChildren: './lu5/lu5.module#Lu5Module',
  },{
    path: 'importar',
    loadChildren: './importar/importar.module#ImportarModule',
  },{
    path: 'agendas',
    loadChildren: './agendas/agendas.module#AgendasModule',
  },{
    path: 'lmneuquen',
    loadChildren: './lmneuquen/lmneuquen.module#LmneuquenModule',
  },{
    path: 'lmcipolletti',
    loadChildren: './lmcipolletti/lmcipolletti.module#LmcipollettiModule',
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
