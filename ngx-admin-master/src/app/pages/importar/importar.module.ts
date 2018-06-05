import { NgModule } from '@angular/core';

import { ThemeModule } from '../../@theme/theme.module';
import { ImportarRoutingModule, routedComponents } from './importar-routing.module';
import { ImportacionComponent } from './importar/importacion.component';
import { GestionEventosComponent } from './gestion_eventos/gestion_eventos.component';
import { ImportarComponent } from './importar.component';

//Mis imports
import { LoadingModule, ANIMATION_TYPES  } from 'ngx-loading';
import { ToasterModule } from 'angular2-toaster';



@NgModule({
  imports: [
    ToasterModule,
    ThemeModule,
    ImportarRoutingModule,
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
    ImportarComponent,
    ImportacionComponent,
    GestionEventosComponent,
    ...routedComponents,
  ],
})
export class ImportarModule { }
