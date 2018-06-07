import { NgModule } from '@angular/core';

import { ThemeModule } from '../../@theme/theme.module';
import { AgendasRoutingModule, routedComponents } from './agendas-routing.module';
import { ImportacionComponent } from './importar/importacion.component';
import { GestionEventosComponent } from './gestion_eventos/gestion_eventos.component';
import { AgendasComponent } from './agendas.component';

//Mis imports
import { LoadingModule, ANIMATION_TYPES  } from 'ngx-loading';
import { ToasterModule } from 'angular2-toaster';



@NgModule({
  imports: [
    ToasterModule,
    ThemeModule,
    AgendasRoutingModule,
    LoadingModule.forRoot({
        animationType: ANIMATION_TYPES.chasingDots,
        backdropBackgroundColour: 'rgba(0,0,0,0.5)', 
        backdropBorderRadius: '4px',
        primaryColour: '#ffffff', 
        secondaryColour: '#ffffff', 
        tertiaryColour: '#ffffff',
        fullScreenBackdrop: true
    })
  ],
  declarations: [
    AgendasComponent,
    ImportacionComponent,
    GestionEventosComponent,
    ...routedComponents,
  ],
})
export class AgendasModule { }
