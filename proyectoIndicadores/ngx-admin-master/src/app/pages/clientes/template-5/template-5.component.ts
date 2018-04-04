import { Component, OnDestroy, Input, Output } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-template-5',
  styleUrls: ['./template-5.component.scss'],
  templateUrl: './template-5.component.html',
})
export class Template5Component implements OnDestroy {

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
