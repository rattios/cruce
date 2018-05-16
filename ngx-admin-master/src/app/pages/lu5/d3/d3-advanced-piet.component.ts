import { Component, OnDestroy } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-d3-advanced-piet',
  template: `
    <ngx-charts-advanced-pie-chart
      [scheme]="colorScheme"
      [results]="single">
    </ngx-charts-advanced-pie-chart>
  `,
})
export class D3AdvancedPietComponent implements OnDestroy {
  single = [
    {
      name: 'Usuario 23',
      value: 55,
    },
    {
      name: 'Usuario 77',
      value: 43,
    },
    {
      name: 'Usuario 12',
      value: 30,
    },
    {
      name: 'Usuario 44',
      value: 24,
    },
    {
      name: 'Usuario 67',
      value: 9,
    },
  ];
  colorScheme: any;
  themeSubscription: any;

  constructor(private theme: NbThemeService) {
    this.themeSubscription = this.theme.getJsTheme().subscribe(config => {
      const colors: any = config.variables;
      this.colorScheme = {
        domain: [colors.primaryLight, colors.infoLight, colors.successLight, colors.warningLight, colors.dangerLight],
      };
    });
  }

  ngOnDestroy(): void {
    this.themeSubscription.unsubscribe();
  }
}
