import { Component, OnDestroy,Input } from '@angular/core';
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
  @Input() informacion:any;

  ngOnInit(): void {
      console.log(this.informacion);
      if(this.informacion!=undefined) {
       
      }
      this.results = [
        { name: 'Tweets', value: this.informacion.tweets_count },
        { name: 'Favoritos', value: this.informacion.favorite_count },
        { name: 'Retweets', value: this.informacion.retweet_count },
      ];
    }

  results:any;

  
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
