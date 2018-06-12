import { Component, OnDestroy,Input } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-d3-bart',
  template: `
    <ngx-charts-bar-vertical
      [scheme]="colorScheme"
      [results]="results"
      [xAxis]="showXAxis"
      [yAxis]="showYAxis"
      [legend]="showLegend"
      [xAxisLabel]="xAxisLabel"
      [yAxisLabel]="yAxisLabel">
    </ngx-charts-bar-vertical>
  `,
})
export class D3BartComponent implements OnDestroy {
  @Input() informacion:any;

  ngOnInit(): void {
      console.log(this.informacion);
      if(this.informacion!=undefined) {
       
      }

       this.results = [
        { name: 'Tweets', value: this.informacion.tweets_count },
        { name: 'Favoritos', value: this.informacion.favorite_count },
        { name: 'Retweets', value: this.informacion.retweet_count },
        { name: 'Hashtags', value:this.informacion.hashtags },
        { name: 'Urls', value:this.informacion.urls },
        { name: 'Mentions', value:this.informacion.user_mentions },
      ];
      





    }

  results:any;
 
  showLegend = true;
  showXAxis = true;
  showYAxis = true;
  xAxisLabel = 'Country';
  yAxisLabel = 'Population';
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
