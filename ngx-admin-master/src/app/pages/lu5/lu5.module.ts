import { NgModule } from '@angular/core';
import { ThemeModule } from '../../@theme/theme.module';
import { Lu5RoutingModule, routedComponents } from './lu5-routing.module';

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

import { StatusCardComponent } from './lu5-twitter/status-card/status-card.component';

let fbLoginOptions: LoginOpt = {
  scope: 'user_posts,user_likes,user_birthday,user_friends,user_location,publish_pages,pages_messaging,pages_messaging_subscriptions,email',
  return_scopes: true,
  enable_profile_selector: true
}; // https://developers.facebook.com/docs/reference/javascript/FB.login/v2.11

let config = new AuthServiceConfig([
  {
    id: GoogleLoginProvider.PROVIDER_ID,
    provider: new GoogleLoginProvider('624796833023-clhjgupm0pu6vgga7k5i5bsfp6qp6egh.apps.googleusercontent.com')
  },
  {
    id: FacebookLoginProvider.PROVIDER_ID,
    provider: new FacebookLoginProvider('285042418695430',fbLoginOptions)
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
    Lu5RoutingModule,
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
    SocialLoginModule
  ],
  declarations: [
    ...routedComponents,
   StatusCardComponent,
  ],
   providers: [
    {
      provide: AuthServiceConfig,
      useFactory: provideConfig
    }
  ],
})
export class Lu5Module { }
