import { Component, OnDestroy, Input, Output } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-template-1',
  styleUrls: ['./template-1.component.scss'],
  templateUrl: './template-1.component.html',
})
export class Template1Component implements OnDestroy {

  currentTheme: string;
  themeSubscription: any;

  @Input() data: any;

  //img = 'assets/images/kitten-default.png';
  img = 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/Angular_full_color_logo.svg/250px-Angular_full_color_logo.svg.png';

  constructor(private themeService: NbThemeService) {
    this.themeSubscription = this.themeService.getJsTheme().subscribe(theme => {
      this.currentTheme = theme.name;
    });
  }

  ngOnDestroy() {
    this.themeSubscription.unsubscribe();
  }
}
