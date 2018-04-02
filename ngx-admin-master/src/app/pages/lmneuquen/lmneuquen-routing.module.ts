import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LmneuquenComponent } from './lmneuquen.component';
import { LmneuquenFacebookComponent } from './lmneuquen-facebook/lmneuquen-facebook.component';
import { LmneuquenTwitterComponent } from './lmneuquen-twitter/lmneuquen-twitter.component';
import { LmneuquenInstagramComponent } from './lmneuquen-instagram/lmneuquen-instagram.component';


const routes: Routes = [{
  path: '',
  component: LmneuquenComponent,
  children: [{
    path: 'facebook',
    component: LmneuquenFacebookComponent,
  },{
    path: 'twitter',
    component: LmneuquenTwitterComponent,
  },{
    path: 'instagram',
    component: LmneuquenInstagramComponent,
  }],
}];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
  ],
  exports: [
    RouterModule,
  ],
})
export class LmneuquenRoutingModule {

}

export const routedComponents = [
  LmneuquenComponent,
  LmneuquenFacebookComponent,
  LmneuquenTwitterComponent,
  LmneuquenInstagramComponent,
];
