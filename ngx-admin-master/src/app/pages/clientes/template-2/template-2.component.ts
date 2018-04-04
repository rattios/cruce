import { Component, OnDestroy, Input, Output } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-template-2',
  styleUrls: ['./template-2.component.scss'],
  templateUrl: './template-2.component.html',
})
export class Template2Component implements OnDestroy {

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
