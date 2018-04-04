import { Component, OnDestroy, Input, OnInit } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-chartjs-pie',
  template: `
    <chart type="pie" [data]="data" [options]="options"></chart>
  `,
})
export class ChartjsPieComponent implements OnDestroy {
  data: any;
  options: any;
  themeSubscription: any;

  @Input() dataDiagrama:any;

  constructor(private theme: NbThemeService) {

  }

  ngOnInit() {

    this.themeSubscription = this.theme.getJsTheme().subscribe(config => {

      const colors: any = config.variables;
      const chartjs: any = config.variables.chartjs;

      this.data = {
        labels: ['Mongo mensajes', 'Sorteo web', 'Cleaned members', 'Subscribed members'],
        datasets: [{
          data: [this.dataDiagrama.N_Parse, this.dataDiagrama.N_SorteoWeb, this.dataDiagrama.N_Cleaned_members, this.dataDiagrama.N_Subscribed_members],
          backgroundColor: [colors.primaryLight, colors.infoLight, colors.successLight, colors.warningLight],
        }],
      };

      this.options = {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          xAxes: [
            {
              display: false,
            },
          ],
          yAxes: [
            {
              display: false,
            },
          ],
        },
        legend: {
          labels: {
            fontColor: chartjs.textColor,
          },
        },
      };
    });
  }

  ngOnDestroy(): void {
    this.themeSubscription.unsubscribe();
  }
}
