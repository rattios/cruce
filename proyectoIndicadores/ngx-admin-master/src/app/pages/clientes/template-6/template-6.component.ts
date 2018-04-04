import { Component, OnDestroy, Input, Output } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-template-6',
  styleUrls: ['./template-6.component.scss'],
  templateUrl: './template-6.component.html',
})
export class Template6Component implements OnDestroy {

  currentTheme: string;
  themeSubscription: any;

  @Input() data: any;

  img = 'assets/images/kitten-default.png';

  constructor(private themeService: NbThemeService) {
    this.themeSubscription = this.themeService.getJsTheme().subscribe(theme => {
      this.currentTheme = theme.name;
    });
  }

  ngOnDestroy() {
    this.themeSubscription.unsubscribe();
  }
}
