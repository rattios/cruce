import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ImportarComponent } from './importar.component';
import { ImportacionComponent } from './importar/importacion.component';
import { GestionEventosComponent } from './gestion_eventos/gestion_eventos.component';
import { UsuariosComponent } from './usuarios/usuarios.component';


const routes: Routes = [{
  path: '',
  component: ImportarComponent,
  children: [{
    path: 'importar',
    component: ImportacionComponent,
  },{
    path: 'gestion_eventos',
    component: GestionEventosComponent,
  },{
    path: 'usuarios',
    component: UsuariosComponent,
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
export class ImportarRoutingModule {

}

export const routedComponents = [
  ImportarComponent,
  ImportacionComponent,
  UsuariosComponent
];
