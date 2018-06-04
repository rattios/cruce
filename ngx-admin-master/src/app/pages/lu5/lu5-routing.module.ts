import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { Lu5Component } from './lu5.component';
import { Lu5FacebookComponent } from './lu5-facebook/lu5-facebook.component';
import { Lu5TwitterComponent } from './lu5-twitter/lu5-twitter.component';
import { Lu5InstagramComponent } from './lu5-instagram/lu5-instagram.component';
import { Lu5YoutubeComponent } from './lu5-youtube/lu5-youtube.component';

const routes: Routes = [{
  path: '',
  component: Lu5Component,
  children: [{
    path: 'facebook',
    component: Lu5FacebookComponent,
  },{
    path: 'twitter',
    component: Lu5TwitterComponent,
  },{
    path: 'instagram',
    component: Lu5InstagramComponent,
  },{
    path: 'youtube',
    component: Lu5YoutubeComponent,
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
export class Lu5RoutingModule {

}

export const routedComponents = [
  Lu5Component,
  Lu5FacebookComponent,
  Lu5TwitterComponent,
  Lu5InstagramComponent,
  Lu5YoutubeComponent
];
