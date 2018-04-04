import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

import { AngularFireAuth } from 'angularfire2/auth';
import * as firebase from 'firebase/app';
import { Observable } from 'rxjs/Observable';

declare const $: any;
declare var google: any;

@Component({
  selector: 'ngx-lmneuquen-twitter',
  styleUrls: ['./lmneuquen-twitter.component.scss'],
  templateUrl: './lmneuquen-twitter.component.html',
})
export class LmneuquenTwitterComponent implements OnInit{

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
	public mostrar = true;

	//Formularios
	myFormAgregar: FormGroup;

  @ViewChild('fileInput') fileInput: ElementRef;
  clear = false; //puedo borrar?
  fileIMG = null;
  imgUpload = null;
  loadinImg = false;

  constructor( private toasterService: ToasterService,
           private http: HttpClient,
           private router: Router,
           private rutaService: RutaBaseService,
           public fb: FormBuilder, public afAuth: AngularFireAuth)
  {

  	this.myFormAgregar = this.fb.group({
        nombre: ['', [Validators.required]],
        imagen: ['', [Validators.required]]
      });
  }

  ngOnInit() {
    
  }

  public displayName;
  public email;
  public accessToken;
  public secret;
  public id_twitter;
  loginTwitter(){
    this.afAuth.auth.signInWithPopup(new firebase.auth.TwitterAuthProvider())
    .then((res)=>{
      console.log(res);
      this.displayName=res.user.displayName;
      this.email=res.user.email;
      this.accessToken=res.credential.accessToken;
      this.secret=res.credential.secret;
      this.id_twitter=res.additionalUserInfo.profile.id;
      var send={
        id_twitter:this.id_twitter,
        display_name:this.displayName,
        email:this.email,
        access_token:this.accessToken,
        secret:this.secret
      }
      console.log(send);
      this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/login/twitter', send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.data = data;

              //alert(this.data.message);
              this.loading = false;
              this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
              this.getDatosTwitter();
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);

             this.loading = false;

             //token invalido/ausente o token expiro
             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
      })
    .catch(err=>console.log(err))
  }

  public usuarios:any;
  public mentions:any;
  public timeline:any;
  public publicaciones:any;
  getDatosTwitter(){
    var send={
      display_name:this.displayName
    }
    this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/twitterFollowers',send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.usuarios=data;
              this.usuarios=this.usuarios.twitter.data.users;
              
              //this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
  
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);

             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );

    this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/twitterUserTimeLine',send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.publicaciones=data;
              this.mentions=this.publicaciones.mentions.mentions;
              this.timeline=this.publicaciones.timeline.timeline;
              
              //this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
  
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);

             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
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

    crear() {
      console.log(this.myFormAgregar.value);

      this.loading = true;

      var datos= {
        token: localStorage.getItem('mouvers_token'),
        nombre: this.myFormAgregar.value.nombre,
        imagen: this.myFormAgregar.value.imagen,
        estado: 'ON',
      }
      console.log(datos);

      this.http.post(this.rutaService.getRutaApi()+'mouversAPI/public/categorias', datos)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.data = data;

              //alert(this.data.message);
              this.loading = false;
              this.showToast('success', 'Success!', this.data.message);

              this.myFormAgregar.reset();
              this.clearFile();
  
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);

             this.loading = false;

             //token invalido/ausente o token expiro
             if(msg.status == 400 || msg.status == 401){ 
                  //alert(msg.error.error);
                  //ir a login

                  this.showToast('warning', 'Warning!', msg.error.error);
                  //this.mostrar = false;
              }
              else { 
                  //alert(msg.error.error);
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
    }

    //Carga de img---<
    subirImagen(): void {
     
      this.loading = true;

      const formModel = this.prepareSave();

      this.http.post(this.rutaService.getRutaApi()+'mouversAPI/public/imagenes?token='+localStorage.getItem('mouvers_token'), formModel)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.data = data;
              this.imgUpload = this.data.imagen;
              this.myFormAgregar.patchValue({imagen : this.imgUpload});

              //Solo admitimos imágenes.
               if (!this.fileIMG.type.match('image.*')) {
                    return;
               }

               var reader = new FileReader();

               reader.onload = (function(theFile) {
                   return function(e) {
                   // Creamos la imagen.
                    document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result, '" height="160px"/>'].join('');
                   };
               })(this.fileIMG);
     
               reader.readAsDataURL(this.fileIMG);

               this.clear = true;

              this.loading = false;
              this.showToast('success', 'Success!', this.data.message); 
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);

             this.loading = false;

             //token invalido/ausente o token expiro
             if(msg.status == 400 || msg.status == 401){ 
                  //alert(msg.error.error);
                  //ir a login
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  //alert(msg.error.error);
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
    }

    private prepareSave(): any {
      let input = new FormData();
      input.append('imagen', this.fileIMG);
      input.append('carpeta', 'categorias');
      input.append('url_imagen', this.rutaService.getRutaImages());
      return input;
    }

    onFileChange(event) {
      if(event.target.files.length > 0) {
        this.fileIMG = event.target.files[0];

        this.subirImagen();
      }
    }

    clearFile() {
      this.imgUpload = null;
      this.fileInput.nativeElement.value = '';

      this.clear = false;

      this.myFormAgregar.patchValue({imagen : null});
    }
    //Carga de img--->

    
}
