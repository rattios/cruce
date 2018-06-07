import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AgendasComponent } from './agendas.component';
import { ImportacionComponent } from './importar/importacion.component';
import { GestionEventosComponent } from './gestion_eventos/gestion_eventos.component';


const routes: Routes = [{
  path: '',
  component: AgendasComponent,
  children: [{
    path: 'importar',
    component: ImportacionComponent,
  },{
    path: 'gestion_eventos',
    component: GestionEventosComponent,
  },],
}];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
  ],
  exports: [
    RouterModule,
  ],
})
export class AgendasRoutingModule {

}

export const routedComponents = [
  AgendasComponent,
  ImportacionComponent,
  GestionEventosComponent
];
