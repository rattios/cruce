import { Component, OnInit, ElementRef, ViewChild, ChangeDetectorRef } from '@angular/core';

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
  selector: 'ngx-lu5-twitter',
  styleUrls: ['./lu5-twitter.component.scss'],
  templateUrl: './lu5-twitter.component.html',
})
export class Lu5TwitterComponent implements OnInit{

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
  public estadisticas = false;

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
           public fb: FormBuilder, public afAuth: AngularFireAuth,private cdRef:ChangeDetectorRef)
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
    this.estadisticas=false;
    this.loading = true;
    this.afAuth.auth.signInWithPopup(new firebase.auth.TwitterAuthProvider())
    .then((res)=>{
      console.log(res);
      this.mentions=[];
      this.timeline=[];
      this.usuarios=[];
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
              //this.loading = false;
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
    this.mentions=[];
    this.timeline=[];
    this.usuarios=[];
    this.favorite_count=0;
    this.retweet_count=0;
    this.hashtags=0;
    this.urls=0;
    this.user_mentions=0;
    this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/twitterFollowers',send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.usuarios=data;
              this.usuarios=this.usuarios.twitter.data.users;
              //this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
              this.getEstadisticas();
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading = false;
             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );

    this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/twitterUserTimeLine',send)
      //this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/getTeewts')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.publicaciones=data;
              this.mentions=this.publicaciones.mentions.mentions;
              this.timeline=this.publicaciones.timeline.timeline;
              this.getEstadisticas();

              //this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
  
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading = false;
             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
  }
  getDatosTwitter2(){
    this.loading = true;
    this.mentions=[];
    this.timeline=[];
    this.usuarios=[];
    this.favorite_count=0;
    this.retweet_count=0;
    this.hashtags=0;
    this.urls=0;
    this.user_mentions=0;
    this.displayName='usuario de prueba';
    this.email='usuario@correo.com';
    this.estadisticas = false;
    this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/getTeewts')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.publicaciones=data;
              this.mentions=this.publicaciones.mentions.mentions;
              this.timeline=this.publicaciones.timeline.timeline;
              this.usuarios=this.publicaciones.data.users;
              
              this.getEstadisticas();
              //this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
  
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading = false;
             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
  }
  public favorite_count=0;
  public retweet_count=0;
  public hashtags=0;
  public urls=0;
  public user_mentions=0;
  public datosEstadisticas:any;
  public getEstadisticas(){
      console.log(this.timeline);
      console.log(this.usuarios);

      for (var i = 0; i < this.timeline.length; ++i) {
        this.favorite_count=this.favorite_count+this.timeline[i].favorite_count;
        this.retweet_count=this.retweet_count+this.timeline[i].retweet_count;

        for (var j = 0; j < this.timeline[i].entities.hashtags.length; j++) {
          this.hashtags++;
        }
        for (var q = 0; q < this.timeline[i].entities.urls.length; q++) {
          this.urls++;
        }
        for (var k = 0; k < this.timeline[i].entities.user_mentions.length; k++) {
          this.user_mentions++;
        }
      }
      //usuarios relacionados con los tweets
      var usr:any=[];
      for (var i = 0; i < this.mentions.length; i++) {
            usr.push({
              usuario:this.mentions[i].user.screen_name,
              n:0
            });
      }
      var hash = {};
      usr = usr.filter(function(current) {
        var exists = !hash[current.usuario] || false;
        hash[current.usuario] = true;
        return exists;
      });
      for (var i = 0; i < usr.length; i++) {
        for (var j = 0; j < this.mentions.length; j++) {
          if(usr[i].usuario==this.mentions[j].user.screen_name) {
            usr[i].n++;
          }
        }
      }
      usr.sort((a, b) => b.n - a.n);
      console.log(usr);

      //seguidores que han twitteado
      for (var i = 0; i < this.usuarios.length; i++) {
        this.usuarios[i].nTweets=0;
        for (var j = 0; j < this.mentions.length; j++) {
          if(this.usuarios[i].screen_name==this.mentions[j].user.screen_name) {
            this.usuarios[i].nTweets++;
          }
        }
      }

      var seguidores:any=[];
      for (var i = 0; i < this.usuarios.length; i++) {
        seguidores.push({
          usuario:this.usuarios[i].screen_name,
          n:this.usuarios[i].nTweets
        });
      }
      seguidores.sort((a, b) => b.n - a.n);
      console.log(seguidores);
      this.datosEstadisticas={
        usr:usr,
        seguidores:seguidores,
        tweets_count:this.timeline.length,
        favorite_count:this.favorite_count,
        retweet_count:this.retweet_count,
        hashtags:this.hashtags,
        urls:this.urls,
        user_mentions:this.user_mentions,
      }
      //this.estadisticas=true;

      console.log(this.datosEstadisticas);
      setTimeout(() => {
        console.log("hello");
        this.estadisticas=true; 
        this.loading = false; 
        this.cdRef.detectChanges();
      }, 2000);
      
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
