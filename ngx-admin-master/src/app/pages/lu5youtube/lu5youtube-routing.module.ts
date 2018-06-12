import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { Lu5Component } from './lu5.component';
import { Lu5YoutubeComponent } from './lu5-youtube/lu5-youtube.component';

const routes: Routes = [{
  path: '',
  component: Lu5Component,
  children: [{
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
export class Lu5youtubeRoutingModule {

}

export const routedComponents = [
  Lu5Component,
  Lu5YoutubeComponent
];
