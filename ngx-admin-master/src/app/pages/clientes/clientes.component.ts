import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

import { NgbModal, ModalDismissReasons } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'ngx-clientes',
  styleUrls: ['./clientes.component.scss'],
  templateUrl: './clientes.component.html',
})
export class ClientesComponent {

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
	public productList:any;

	public loading = false;
	public mostrar = false;

	public participaciones:any;
	public objSelected:any;

	constructor(private modalService: NgbModal,
		private toasterService: ToasterService,
        private http: HttpClient,
        private router: Router,
        private rutaService: RutaBaseService,
        public fb: FormBuilder){

	}

	ngOnInit() {
	    this.loading = true;
	    this.http.get(this.rutaService.getRutaApi()+'cruceAPI/public/lista/clientes')
	       .toPromise()
	       .then(
	         data => { // Success
	           console.log(data);
	           this.data=data;
	           this.productList = this.data.clientes;
	           this.filteredItems = this.productList;
	           //console.log(this.productList);

	           this.init();

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
	            //sin usuarios
	            else if(msg.status == 404){ 
	                //alert(msg.error.error);
	                this.showToast('info', 'Info!', msg.error.error);
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

	//Abrir modal por defecto
	open(modal) {
		this.modalService.open(modal);
	}

	//Abrir modal larga
	open2(modal) {
		this.modalService.open(modal , { size: 'lg', backdrop: true, container: 'nb-layout', keyboard: false});
	}

	verParticipaciones(cliente, modal) {

		this.participaciones = null;

		this.objSelected = cliente;

		this.loading = true;
	    this.http.get(this.rutaService.getRutaApi()+'cruceAPI/public/clientes/participaciones/'+cliente.email)
	       .toPromise()
	       .then(
	         data => { // Success
	           console.log(data);
	           this.data=data;
	           this.participaciones = this.data.participaciones;

	           if(this.participaciones.length == 0){
                        //alert('Sin participaciones');
                        this.showToast('info', 'Info!', 'Sin participaciones');
                        this.loading = false;
                }else{
                	setTimeout(()=>{
	                	this.open2(modal);
		                this.loading = false;
		             },1000);
                }

                for (var i = 0; i < this.participaciones.length; i++) {
                    if(this.participaciones[i].evento != 'Mongo Mensajes'){
                        this.participaciones[i].fecha = new Date(this.participaciones[i].fecha);
                    }
                } 

	         },
	         msg => { // Error
	           console.log(msg);
	           console.log(msg.error.error);

	           this.loading = false;

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

   //----Tabla<
   filteredItems : any;
   pages : number = 4;
   pageSize : number = 5;
   pageNumber : number = 0;
   currentIndex : number = 1;
   items: any;
   pagesIndex : Array<number>;
   pageStart : number = 1;
   inputName : string = '';

   init(){
         this.currentIndex = 1;
         this.pageStart = 1;
         this.pages = 4;

         this.pageNumber = parseInt(""+ (this.filteredItems.length / this.pageSize));
         if(this.filteredItems.length % this.pageSize != 0){
            this.pageNumber ++;
         }
    
         if(this.pageNumber  < this.pages){
               this.pages =  this.pageNumber;
         }
       
         this.refreshItems();
         console.log("this.pageNumber :  "+this.pageNumber);
   }

   FilterByName(){
      this.filteredItems = [];
      if(this.inputName != ""){
            for (var i = 0; i < this.productList.length; ++i) {
              if (this.productList[i].email.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                 this.filteredItems.push(this.productList[i]);
              }else if (this.productList[i].participaciones_evento.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                 this.filteredItems.push(this.productList[i]);
              }
            }
      }else{
         this.filteredItems = this.productList;
      }
      console.log(this.filteredItems);
      this.init();
   }
   fillArray(): any{
      var obj = new Array();
      for(var index = this.pageStart; index< this.pageStart + this.pages; index ++) {
                  obj.push(index);
      }
      return obj;
   }
   refreshItems(){
       this.items = this.filteredItems.slice((this.currentIndex - 1)*this.pageSize, (this.currentIndex) * this.pageSize);
       this.pagesIndex =  this.fillArray();
   }
   prevPage(){
      if(this.currentIndex>1){
         this.currentIndex --;
      } 
      if(this.currentIndex < this.pageStart){
         this.pageStart = this.currentIndex;
      }
      this.refreshItems();
   }
   nextPage(){
      if(this.currentIndex < this.pageNumber){
            this.currentIndex ++;
      }
      if(this.currentIndex >= (this.pageStart + this.pages)){
         this.pageStart = this.currentIndex - this.pages + 1;
      }
 
      this.refreshItems();
   }
    setPage(index : number){
         this.currentIndex = index;
         this.refreshItems();
    }
  //----Tabla>

}
