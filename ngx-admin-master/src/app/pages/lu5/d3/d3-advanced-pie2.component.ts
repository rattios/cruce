import { Component, OnDestroy } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-d3-advanced-pie2',
  template: `
    <ngx-charts-advanced-pie-chart
      [scheme]="colorScheme"
      [results]="single">
    </ngx-charts-advanced-pie-chart>
  `,
})
export class D3AdvancedPie2Component implements OnDestroy {
  single = [
    {
      name: 'Usuario 13',
      value: 81,
    },
    {
      name: 'Usuario 66',
      value: 65,
    },
    {
      name: 'Usuario 12',
      value: 45,
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
