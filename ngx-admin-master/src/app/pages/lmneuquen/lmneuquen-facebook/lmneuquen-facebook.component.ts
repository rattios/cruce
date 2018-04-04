import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';

import { AuthService } from 'angularx-social-login';
import { SocialUser } from 'angularx-social-login';
import { GoogleLoginProvider, FacebookLoginProvider } from 'angularx-social-login';


declare const $: any;
declare var google: any;

@Component({
  selector: 'ngx-lmneuquen-facebook',
  styleUrls: ['./lmneuquen-facebook.component.scss'],
  templateUrl: './lmneuquen-facebook.component.html',
})
export class LmneuquenFacebookComponent implements OnInit{


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

  public user={
    id:'',
    authToken:'',
    name:'',
    email:'',
    photoUrl:''
  };
  public name:any;
  public email:any;
  public photoUrl: any;

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
           public fb: FormBuilder,private authService: AuthService)
  {

    this.myFormAgregar = this.fb.group({
        nombre: ['', [Validators.required]],
        imagen: ['', [Validators.required]]
      });
  }
  
  ngOnInit() {
    this.authService.authState.subscribe((user) => {
      this.user = user;
      console.log(this.user);
      this.name=this.user.name;
      this.email=this.user.email;
      this.photoUrl=this.user.photoUrl;

      var send={
        id_facebook:this.user.id,
        email:this.user.email,
        nombre:this.user.name, 
        access_token:this.user.authToken,
       // data:JSON.stringify(this.user)
      };
      console.log(send);
      this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/login/facebook', send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.data = data;

              //alert(this.data.message);
              this.loading = false;
              this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
              this.getDatos();
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

    });
  }

  signInWithFB(): void {
    this.authService.signIn(FacebookLoginProvider.PROVIDER_ID);
    this.authService.authState.subscribe((user) => {
      this.user = user;
      console.log(this.user);
      this.name=this.user.name;
      this.email=this.user.email;
      this.photoUrl=this.user.photoUrl;

      var send={
        id_facebook:this.user.id,
        email:this.user.email,
        nombre:this.user.name, 
        access_token:this.user.authToken,
       // data:JSON.stringify(this.user)
      };
      console.log(send);
      this.http.post('http://vivomedia.com.ar/vivoindex/cruceAPI/public/login/facebook', send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.data = data;

              //alert(this.data.message);
              this.loading = false;
              this.showToast('success', 'Registrado con éxito en la bd!', this.data.message);
              this.getDatos();
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

    });
  }

  signOut(): void {
    this.authService.signOut();
  }
  public prepost:any;
  public post:any=[];
  public auxComments:any={
    "data":[{
      message:'',
      from:{
        name:''
      }
    }]
  };
  public auxLikes:any={
    data:[{
      message:''
    }]
  };
  getDatos(){
    //https://graph.facebook.com/v2.12/me/comments?access_token=
    this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token='+this.user.authToken)
    //this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token=EAAEDPpwcvQYBALnczQimSVo7RystX6qXafgUeuIyQi6PYKZCO0q7dRCMxjhscQGgwg5KY9Rh4F1kBFNKRZC1vzgUP9dxCZCGxG9S9qe1lRu4eT7QuuUQZAuAnuIRqHSMuE4ZCb0wp4pIfZC6BymD0Ut6Md6MkrOw7bxPxadG0V00awTq8CVDl8B9tOD8zw9xEjMN1D1quVbgZDZD')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.post=[];
              this.prepost=data;
              this.prepost=this.prepost.posts.data;
              for (var i = 0; i < this.prepost.length; i++) {
                if(this.prepost[i].likes){
                  if(this.prepost[i].comments) {
                    this.post.push(this.prepost[i]);
 
                  }else{
                    this.prepost[i].comments=this.auxComments;
                    this.post.push(this.prepost[i]);
 
                  }
                }else if(this.prepost[i].comments){
                  if(this.prepost[i].likes) {
                    this.post.push(this.prepost[i]);
 
                  }else{
                    this.prepost[i].likes=this.auxLikes;
                    this.post.push(this.prepost[i]);
 
                  }
                }else{
                }
              }
              console.log(this.post);
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

}