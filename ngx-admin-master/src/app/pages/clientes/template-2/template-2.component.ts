import { Component, OnInit, HostBinding, Input, OnDestroy } from '@angular/core';
import { PlayerService, Track } from '../../../@core/data/player.service';

@Component({
  selector: 'ngx-template-2',
  styleUrls: ['./template-2.component.scss'],
  templateUrl: './template-2.component.html',
})
export class Template2Component implements OnDestroy {

  @Input()
  @HostBinding('class.collapsed')
  collapsed: boolean;

  track: Track;
  player: HTMLAudioElement;
  shuffle: boolean;

  @Input() data: any;

  aux =
  {
    name: 'Don\'t Wanna Fight',
    artist: 'Alabama Shakes',
    url: 'https://p.scdn.co/mp3-preview/6156cdbca425a894972c02fca9d76c0b70e001af',
    cover: 'assets/images/cover1.jpg',
  };

  constructor(private playerService: PlayerService) {
    //this.track = this.playerService.random();
    //this.createPlayer();
  }

  ngOnInit() {
    console.log(this.data);
    this.track = this.aux;
    this.track.name = this.data.nombre;
    this.track.artist = this.data.fecha;
    this.track.url = this.data.url;
    this.createPlayer();
  }


  ngOnDestroy() {
    this.player.pause();
    this.player.src = '';
    this.player.load();
  }

  prev() {
    if (!this.player.loop) {
      if (this.shuffle) {
        this.track = this.playerService.random();
      } else {
        this.track = this.playerService.prev();
      }
    }

    this.reload();
  }

  next() {
    if (!this.player.loop) {
      if (this.shuffle) {
        this.track = this.playerService.random();
      } else {
        this.track = this.playerService.next();
      }
    }

    this.reload();
  }

  playPause() {
    if (this.player.paused) {
      this.player.play();
    } else {
      this.player.pause();
    }
  }

  toggleShuffle() {
    this.shuffle = !this.shuffle;
  }

  toggleLoop() {
    this.player.loop = !this.player.loop;
  }

  setVolume(volume: number) {
    this.player.volume = volume / 100;
  }

  getVolume(): number {
    return this.player.volume * 100;
  }

  setProgress(duration: number) {
    this.player.currentTime = this.player.duration * duration / 100;
  }

  getProgress(): number {
    return this.player.currentTime / this.player.duration * 100 || 0;
  }

  private createPlayer() {
    this.player = new Audio();
    this.player.onended = () => this.next();
    this.setTrack();
  }

  private reload() {
    this.setTrack();
    this.player.play();
  }

  private setTrack() {
    this.player.src = this.track.url;
    this.player.load();
  }
}
