import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LmcipollettiComponent } from './lmcipolletti.component';
import { LmcipollettiFacebookComponent } from './lmcipolletti-facebook/lmcipolletti-facebook.component';
import { LmcipollettiTwitterComponent } from './lmcipolletti-twitter/lmcipolletti-twitter.component';
import { LmcipollettiInstagramComponent } from './lmcipolletti-instagram/lmcipolletti-instagram.component';


const routes: Routes = [{
  path: '',
  component: LmcipollettiComponent,
  children: [{
    path: 'facebook',
    component: LmcipollettiFacebookComponent,
  },{
    path: 'twitter',
    component: LmcipollettiTwitterComponent,
  },{
    path: 'instagram',
    component: LmcipollettiInstagramComponent,
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
export class LmcipollettiRoutingModule {

}

export const routedComponents = [
  LmcipollettiComponent,
  LmcipollettiFacebookComponent,
  LmcipollettiTwitterComponent,
  LmcipollettiInstagramComponent,
];
