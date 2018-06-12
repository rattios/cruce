import { Component, OnDestroy,Input } from '@angular/core';
import { NbThemeService } from '@nebular/theme';

@Component({
  selector: 'ngx-d3-advanced-pie',
  template: `
    <ngx-charts-advanced-pie-chart
      [scheme]="colorScheme"
      [results]="single">
    </ngx-charts-advanced-pie-chart>
  `,
})
export class D3AdvancedPieComponent implements OnDestroy {
  @Input() informacion:any;

  ngOnInit(): void {
      console.log(this.informacion);
      if(this.informacion!=undefined) {
       
      }
      /*this.single = [
        {
          name: this.informacion.n1Comentarios.usuario,
          value: this.informacion.n1Comentarios.n,
        },
        {
          name: this.informacion.n2Comentarios.usuario,
          value: this.informacion.n2Comentarios.n,
        },
        {
          name: this.informacion.n3Comentarios.usuario,
          value: this.informacion.n3Comentarios.n,
        },
      ];*/
      for (var i = 0; i < this.informacion.com.length; i++) {
        this.single.push({
          name:this.informacion.com[i].usuario,
          value:this.informacion.com[i].n,
        });
      }
      
  }
  single:any=[];
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
