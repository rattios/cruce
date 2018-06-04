import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

import { NgbModal, ModalDismissReasons } from '@ng-bootstrap/ng-bootstrap';

import * as XLSX from 'xlsx';

@Component({
  selector: 'ngx-importar',
  styleUrls: ['./importar.component.scss'],
  templateUrl: './importar.component.html',
})
export class ImportarComponent {

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

	public objSelected:any;

	public isevento=true;
	public istipo_del_evento=true;
	public isdatos_del_envento=false;
	public isobservaciones=true;
	public isid_usuario=false;
	public isusuario=true;
	public isnombre=true;
	public istelefono=true;
	public isdni=true;
	public isemail=true;
	public isciudad=false;
	public ispais=false;
	public isurl=false;
	public iscomentarios=false;
	public isme_gusta=false;
	public isfecha=true;

	constructor(private modalService: NgbModal,
		private toasterService: ToasterService,
        private http: HttpClient,
        private router: Router,
        private rutaService: RutaBaseService,
        public fb: FormBuilder){

	}

	ngOnInit() {
	    
	}

	//inside export class

	arrayBuffer:any;
	file:File;
	incomingfile(event) 
	  {
	  this.file= event.target.files[0]; 
	  }

	 Upload() {
	      let fileReader = new FileReader();
	        fileReader.onload = (e) => {
	            this.arrayBuffer = fileReader.result;
	            var data = new Uint8Array(this.arrayBuffer);
	            var arr = new Array();
	            for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
	            var bstr = arr.join("");
	            var workbook = XLSX.read(bstr, {type:"binary"});
	            var first_sheet_name = workbook.SheetNames[0];
	            var worksheet = workbook.Sheets[first_sheet_name];
	            console.log(XLSX.utils.sheet_to_json(worksheet,{raw:true}));
	            this.objSelected=XLSX.utils.sheet_to_json(worksheet,{raw:true});
	        }
	        fileReader.readAsArrayBuffer(this.file);
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
