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
  selector: 'ngx-importacion',
  styleUrls: ['./importacion.component.scss'],
  templateUrl: './importacion.component.html',
})
export class ImportacionComponent {

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

	public objSelected:any=[];
	public preobjSelected:any;
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

	public usuarios:any;
	public nuevos_usuarios:any=[];

	constructor(private modalService: NgbModal,
		private toasterService: ToasterService,
        private http: HttpClient,
        private router: Router,
        private rutaService: RutaBaseService,
        public fb: FormBuilder){

	}

	public eventos:any;
	ngOnInit() {
	    //this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos')
	    this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos')
         .toPromise()
         .then(
           data => { // Success
             console.log(data);
             this.eventos=data;
             this.eventos=this.eventos.Eventos;
             //this.showToast('success', 'Éxito!', 'Se registro el evento!');
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error);
             this.showToast('error', 'Error!', 'Algo salió mal...!');
           }
        );
        this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos_usuarios')
         .toPromise()
         .then(
           data => { // Success
             console.log(data);
             this.usuarios=data;
             this.usuarios=this.usuarios.usuarios;
             //this.showToast('success', 'Éxito!', 'Se registro el evento!');
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error);
             this.showToast('error', 'Error!', 'Algo salió mal...!');
           }
        );
	}

	//inside export class

	arrayBuffer:any;
	file:File;
	incomingfile(event) 
	  {
	  this.file= event.target.files[0]; 
	    setTimeout(() => {
          this.Upload();
    	}, 1000);
	  
	  }

	 Upload() {
	 		this.objSelected=[];
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
	            this.preobjSelected=XLSX.utils.sheet_to_json(worksheet,{raw:true});
	            for (var i = 0; i < this.preobjSelected.length; i++) {
	            	
	            	if(this.repetidos(this.preobjSelected[i])){
	            		
						this.objSelected.push(this.preobjSelected[i]);
						//this.insertar(this.aux); comentarios datos_del_envento dni email observaciones telefono usuario
					}
	            }
	            setTimeout(() => {
			        this.agregarUsuarios();
			    }, 2000);
	        }
	        fileReader.readAsArrayBuffer(this.file);
	}
	public n_usuarios:any;
	agregarUsuarios(){
		for (var i = 0; i < this.preobjSelected.length; i++) {
        	if(this.repetidos_usuarios(this.preobjSelected[i])){
				this.nuevos_usuarios.push({
					email:this.preobjSelected[i].email,
					nombre:this.preobjSelected[i].nombre,
					telefono:this.preobjSelected[i].telefono,
					dni:this.preobjSelected[i].dni,
					usuario:this.preobjSelected[i].usuario
				});
			}
        }
	}
	guardar_usuarios(){
		setTimeout(() => {
        	console.log(this.usuarios);
        	console.log(this.nuevos_usuarios);
        	var send={
				data:JSON.stringify(this.nuevos_usuarios)
			}
			this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/eventos_usuarios',send)
	         .toPromise()
	         .then(
	           data => { // Success
	             console.log(data);
	             this.n_usuarios=data;
	             this.n_usuarios=this.n_usuarios.length;
	             this.ngOnInit();
	            // this.eventos=data;
	            // this.eventos=this.eventos.Eventos;
	           this.showToast('success', 'Éxito!', 'Se registro '+this.nuevos_usuarios.length+' usuarios nuevos.');
	           },
	           msg => { // Error
	             console.log(msg);
	             console.log(msg.error);
	             this.showToast('error', 'Error!', 'Algo salió mal...!');
	           }
	         );
		}, 2000);
	}
	repetidos_usuarios(obj){
		for (var a = 0; a < this.usuarios.length; a++) {
			if(this.usuarios[a].email==obj.email) {
				return false;
			}
		}
		console.log(obj.email);
		return true;
	}
	repetidos(obj){
		console.log(obj);
		for (var a = 0; a < this.eventos.length; a++) {
			for (var b = 0; b < this.eventos[a].registros.length;b++) {
				if(this.evento_id==this.eventos[a].registros[b].evento_id) {
					if(this.eventos[a].registros[b].telefono==obj.telefono && this.eventos[a].registros[b].datos_del_envento==obj.datos_del_envento && this.eventos[a].registros[b].dni==obj.dni && this.eventos[a].registros[b].email==obj.email && this.eventos[a].registros[b].observaciones==obj.observaciones && this.eventos[a].registros[b].usuario==obj.usuario) {
						return false;
					}
				}
			}
		}
		console.log(obj);
		return true;
	}
	public n_importacion=0;
	public mostrar=false;
	selec(e){
		this.n_importacion=0;
		this.mostrar=true;
		console.log(e.target.value);
		for (var i = 0; i < this.eventos.length; i++) {
			if(e.target.value==this.eventos[i].id) {
				if(this.eventos[i].registros.length>0) {
					for (var j = 0; j < this.eventos[i].registros.length; j++) {
						if(this.eventos[i].registros[j].n_importacion>this.n_importacion) {
							this.n_importacion=this.eventos[i].registros[j].n_importacion;
						}
					}
				}else{
					this.n_importacion=0;
				}	
			}
		}
		console.log(this.n_importacion);
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
	public evento_id=0;
	enviar(){
		console.log(this.evento_id);
		for (var i = 0; i < this.objSelected.length; i++) {
			this.objSelected[i].evento_id=this.evento_id;
			this.objSelected[i].n_importacion=this.n_importacion+1;
		}
		console.log(this.objSelected);
		var send={
			data:JSON.stringify(this.objSelected)
		}
		//this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/importar',send)
		this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/importar',send)
         .toPromise()
         .then(
           data => { // Success
             console.log(data);
             this.ngOnInit();
            // this.eventos=data;
            // this.eventos=this.eventos.Eventos;
           this.showToast('success', 'Éxito!', 'Se registro la importación!');
           this.guardar_usuarios();
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error);
             this.showToast('error', 'Error!', 'Algo salió mal...!');
           }
         );
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
