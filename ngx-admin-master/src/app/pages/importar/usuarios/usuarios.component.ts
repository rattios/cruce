import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

import { NgbModal, ModalDismissReasons } from '@ng-bootstrap/ng-bootstrap';

import * as XLSX from 'xlsx';

@Component({
  selector: 'ngx-usuarios',
  styleUrls: ['./usuarios.component.scss'],
  templateUrl: './usuarios.component.html',
})
export class UsuariosComponent {

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

	public nombre= '';
  public usuarios:any;

	constructor(private modalService: NgbModal,
		private toasterService: ToasterService,
        private http: HttpClient,
        private router: Router,
        private rutaService: RutaBaseService,
        public fb: FormBuilder){

	}

	ngOnInit() {
	    this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos_usuarios')
         .toPromise()
         .then(
           data => { // Success
             console.log(data);
             this.usuarios=data;
             this.usuarios=this.usuarios.usuarios;
              this.productList = this.usuarios;
              this.filteredItems = this.productList;
              this.init();
             //this.showToast('success', 'Éxito!', 'Se registro el evento!');
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.showToast('error', 'Error!', 'Algo salió mal...!');
           }
         );
	}
  
	crear(){
		console.log(this.nombre);
    var send={
      nombre:this.nombre
    }
    //this.http.post(this.rutaService.getRutaApi()+'/cruceAPI/public/eventos',send)
    this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos',send)
         .toPromise()
         .then(
           data => { // Success
             console.log(data);
             this.showToast('success', 'Éxito!', 'Se registro el evento!');
             this.ngOnInit();
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.showToast('error', 'Error!', 'Algo salió mal...!');
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
   checkNull(item){
     if(item==null) {
       return false;
     }else{
       return true;
     }
   }
   FilterByName(){
      this.filteredItems = [];
      if(this.inputName != ""){
            for (var i = 0; i < this.productList.length; ++i) {
              if(this.checkNull(this.productList[i].email)) {
                if (this.productList[i].email.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                   this.filteredItems.push(this.productList[i]);
                }
              }
              else if(this.checkNull(this.productList[i].nombre)){
                if (this.productList[i].nombre.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                   this.filteredItems.push(this.productList[i]);
                }
              }else if(this.checkNull(this.productList[i].telefono)){
                if (this.productList[i].telefono.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                 this.filteredItems.push(this.productList[i]);
                }
              }else if(this.checkNull(this.productList[i].dni)){
                if (this.productList[i].dni.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                 this.filteredItems.push(this.productList[i]);
                }
              }else if(this.checkNull(this.productList[i].usuario)){
                if(this.productList[i].usuario.toUpperCase().indexOf(this.inputName.toUpperCase())>=0) {
                 this.filteredItems.push(this.productList[i]);
                }
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
