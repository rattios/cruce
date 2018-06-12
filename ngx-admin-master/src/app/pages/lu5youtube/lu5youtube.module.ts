import { NgModule } from '@angular/core';
import { ThemeModule } from '../../@theme/theme.module';
import { Lu5youtubeRoutingModule, routedComponents } from './lu5youtube-routing.module';

//Mis imports
import { LoadingModule, ANIMATION_TYPES  } from 'ngx-loading';
import { ToasterModule } from 'angular2-toaster';
//import { Ng2UploaderModule } from 'ng2-uploader';

import { AgmCoreModule } from '@agm/core';
import { AngularFireModule } from 'angularfire2';
import { AngularFireAuthModule } from 'angularfire2/auth';
import { AngularFireAuth } from 'angularfire2/auth';

import { SocialLoginModule} from 'angularx-social-login';
import { AuthServiceConfig, GoogleLoginProvider, FacebookLoginProvider } from 'angularx-social-login';
import { LoginOpt } from 'angularx-social-login';



import { NgxEchartsModule } from 'ngx-echarts';
import { NgxChartsModule } from '@swimlane/ngx-charts';
import { ChartModule } from 'angular2-chartjs';
import { D3BarComponent } from './d3/d3-bar.component';
import { D3PieComponent } from './d3/d3-pie.component';
import { D3AdvancedPieComponent } from './d3/d3-advanced-pie.component';
import { D3AdvancedPie2Component } from './d3/d3-advanced-pie2.component';
import { D3BartComponent } from './d3/d3-bart.component';
import { D3PietComponent } from './d3/d3-piet.component';
import { D3AdvancedPietComponent } from './d3/d3-advanced-piet.component';
import { D3AdvancedPiet2Component } from './d3/d3-advanced-piet2.component';


const googleLoginOptions: LoginOpt = {
  scope: 'profile email openid https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/youtubepartner https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email'
};// https://developers.google.com/api-client-library/javascript/reference/referencedocs#gapiauth2clientconfig

let config = new AuthServiceConfig([
  {
    id: GoogleLoginProvider.PROVIDER_ID,
    provider: new GoogleLoginProvider('1058000793604-e8r8g27g6ck4mapb2b8fmmkjjai42r4f.apps.googleusercontent.com',googleLoginOptions)
  }
]);

export function provideConfig() {
  return config;
}

export const firebaseCredentials = {
  apiKey: 'AIzaSyBq1JhnW096gqIlX-t9msm0Qy-G5qxI2Xg',
  authDomain: 'indicadores-3ed46.firebaseapp.com',
  databaseURL: 'https://indicadores-3ed46.firebaseapp.com',
  projectId: 'indicadores-3ed46',
  storageBucket: '',
  messagingSenderId: ''
};


@NgModule({
  imports: [
    //Ng2UploaderModule,
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyCr8zuLtOO7IoK_rC948rLcqyqsIaZOouY',
      libraries: ["places"]
    }),
    ToasterModule,
    ThemeModule,
    Lu5youtubeRoutingModule,
    LoadingModule.forRoot({
        animationType: ANIMATION_TYPES.chasingDots,
        backdropBackgroundColour: 'rgba(0,0,0,0.5)', 
        backdropBorderRadius: '4px',
        primaryColour: '#ffffff', 
        secondaryColour: '#ffffff', 
        tertiaryColour: '#ffffff',
        fullScreenBackdrop: true
    }),
    AngularFireModule.initializeApp(firebaseCredentials),
    AngularFireAuthModule,
    SocialLoginModule,
    NgxEchartsModule,
    NgxChartsModule,
    ChartModule
  ],
  declarations: [
    ...routedComponents,
   D3BarComponent,
   D3PieComponent,
   D3AdvancedPieComponent,
   D3AdvancedPie2Component,
   D3BartComponent,
   D3PietComponent,
   D3AdvancedPietComponent,
   D3AdvancedPiet2Component
  ],
   providers: [
    {
      provide: AuthServiceConfig,
      useFactory: provideConfig
    }
  ],
})
export class Lu5youtubeModule { }
