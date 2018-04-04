import { Component, OnInit } from '@angular/core';

// Mis imports
import { NbSpinnerService, NbThemeService } from '@nebular/theme';
import { NbJSThemeOptions } from '@nebular/theme/services/js-themes/theme.options';

import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../services/ruta-base/ruta-base.service';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

@Component({
  selector: 'ngx-dashboard',
  styleUrls: ['./dashboard.component.scss'],
  templateUrl: './dashboard.component.html',
})
export class DashboardComponent {

	//----Alertas---<
	config: ToasterConfig;

	position = 'toast-top-right';
	animationType = 'fade';
	title = 'HI there!';
	content = `I'm cool toaster!`;
	timeout = 5000;
	toastsLimit = 5;
	type = 'default'; // 'default', 'info', 'success', 'warning', 'error'

	isNewestOnTop = true;
	isHideOnClick = true;
	isDuplicatesPrevented = false;
	isCloseButton = true;
	//----Alertas--->

	private data:any;

	public loading = false;
	public mostrar = false;

	//Data de la consulta inicial
	clientes:any;
    part1:any;
    part2:any;
    part3:any;
    part4:any;
    est_SorteoWeb_x:any;
    est_SorteoWeb_y:any;
    est_ParseEmails_x:any;
    est_ParseEmails_y:any;
    est_Cleaned_members_x:any;
    est_Cleaned_members_y:any;
    est_Subscribed_members_x:any;
    est_Subscribed_members_y:any;
    N_SorteoWeb:any;
    N_Parse:any;
    N_Cleaned_members:any;
    N_Subscribed_members:any;

    //Data para los diagramas
    public partXevento:any = {
    	N_Parse: 0,
    	N_SorteoWeb: 0,
    	N_Cleaned_members: 0,
    	N_Subscribed_members: 0,
    };

	constructor(public themeService:NbThemeService,
		private toasterService: ToasterService,
        private http: HttpClient,
        private router: Router,
        private rutaService: RutaBaseService
        ){

	}

	ngOnInit() {
		//this.themeService.changeTheme('cosmic');
		this.themeService.changeTheme('default');

		this.loading = true;
	    this.http.get(this.rutaService.getRutaApi()+'cruceAPI/public/dashboard')
	       .toPromise()
	       .then(
	         data => { // Success
	           console.log(data);
	           this.data=data;

				this.clientes=this.data.clientes;
				this.part1=this.data.participaciones1.length;
				this.part2=this.data.participaciones2.length;
				this.part3=this.data.participaciones3.length;
				this.part4=this.data.participaciones4.length;
				this.est_SorteoWeb_x=this.data.Estadisticas_SorteoWeb_x;
				this.est_SorteoWeb_y=this.data.Estadisticas_SorteoWeb_y;
				this.est_ParseEmails_x=this.data.Estadisticas_ParseEmails_x;
				this.est_ParseEmails_y=this.data.Estadisticas_ParseEmails_y;
				this.est_Cleaned_members_x=this.data.Estadisticas_Cleaned_members_x;
				this.est_Cleaned_members_y=this.data.Estadisticas_Cleaned_members_y;
				this.est_Subscribed_members_x=this.data.Estadisticas_Subscribed_members_x;
				this.est_Subscribed_members_y=this.data.Estadisticas_Subscribed_members_y;
				this.N_SorteoWeb=this.data.N_SorteoWeb;
				this.N_Parse=this.data.N_Parse;
				this.N_Cleaned_members=this.data.N_Cleaned_members;
				this.N_Subscribed_members=this.data.N_Subscribed_members;

				//Inicializar diagramas
				this.partXevento.N_Parse = this.N_Parse;
				this.partXevento.N_SorteoWeb = this.N_SorteoWeb;
				this.partXevento.N_Cleaned_members = this.N_Cleaned_members;
				this.partXevento.N_Subscribed_members = this.N_Subscribed_members;

	           this.loading = false;
	           this.mostrar = true;

	         },
	         msg => { // Error
	           console.log(msg);
	           console.log(msg.error.error);

	           this.loading = false;
	           this.mostrar = true;

	           //token invalido/ausente o token expiro
	           if(msg.status == 400 || msg.status == 401){ 
	                //alert(msg.error.error);

	                this.showToast('warning', 'Warning!', msg.error.error);
	                this.mostrar = false;
	            }
	            else{ 
	                //alert(msg.error.error);
	                this.showToast('error', 'Error!', 'Algo salió mal...!');
	            }
	            

	         }
	       );
	}

	private showToast(type: string, title: string, body: string) {
	  this.config = new ToasterConfig({
	    positionClass: this.position,
	    timeout: this.timeout,
	    newestOnTop: this.isNewestOnTop,
	    tapToDismiss: this.isHideOnClick,
	    preventDuplicates: this.isDuplicatesPrevented,
	    animation: this.animationType,
	    limit: this.toastsLimit,
	  });
	  const toast: Toast = {
	    type: type,
	    title: title,
	    body: body,
	    timeout: this.timeout,
	    showCloseButton: this.isCloseButton,
	    bodyOutputType: BodyOutputType.TrustedHtml,
	  };
	  this.toasterService.popAsync(toast);
	}
}
