import { Component, OnDestroy } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-d3-piet',
  template: `
    <ngx-charts-pie-chart
      [scheme]="colorScheme"
      [results]="results"
      [legend]="showLegend"
      [labels]="showLabels">
    </ngx-charts-pie-chart>
  `,
})
export class D3PietComponent implements OnDestroy {
  results = [
    { name: 'Tweets', value: 35 },
    { name: 'Comentarios', value: 143 },
    { name: 'Me gusta', value: 256 },
  ];
  showLegend = true;
  showLabels = true;
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
