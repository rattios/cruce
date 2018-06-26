import { Component, OnInit, ElementRef, ViewChild, ChangeDetectorRef } from '@angular/core';

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
import { FacebookLoginProvider, GoogleLoginProvider } from 'angularx-social-login';


declare const $: any;
declare var google: any;

@Component({
  selector: 'ngx-lu5-facebook',
  styleUrls: ['./lu5-facebook.component.scss'],
  templateUrl: './lu5-facebook.component.html',
})
export class Lu5FacebookComponent implements OnInit{

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
  public name:any='';
  public email:any='';
  public photoUrl: any ='http://vivomedia.com.ar/assets/2.png';
  public estadisticas=false;
  public token:any='EAACEdEose0cBAAZBprP2Yqjh2MOJXfBBTLZC9ZBAMkVkt1TETadAJEDdxYtZACKmAUqyBKEVutNh4uQKjXo4HDZBpoBJGFU38HKa662QIrWZBZAtp3gcv5NUSuq9CfBRi9yPPgOZAI14PGZCp87pASrHQYZAJTcvgfz7ZAbx6pLH8Yp8HU7dR1aucIax61sjoP5ypzzu1D0lkxQ6QZDZD';
  public pagina:any='lasperlascasacervecera';
  public Facebook_friends:any=[];

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
           public fb: FormBuilder,private authService: AuthService,private cdRef:ChangeDetectorRef)
  {

  	this.myFormAgregar = this.fb.group({
        nombre: ['', [Validators.required]],
        imagen: ['', [Validators.required]]
      });
  }
  
  ngOnInit() {
    this.http.get('http://localhost/cruce/cruceAPI/public/facebook_comments')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
           },
           msg => { // Error
             console.log(msg);
           }
         );
    setTimeout(() => {

    this.authService.authState.subscribe((user) => {
      this.user = user;
      console.log(this.user);
      this.name=this.user.name;
      this.email=this.user.email;
      this.photoUrl=this.user.photoUrl;
      this.token=this.user.authToken;
      var send={
        id_facebook:this.user.id,
        email:this.user.email,
        nombre:this.user.name, 
        access_token:this.user.authToken,
       // data:JSON.stringify(this.user)
      };
      console.log(send);
      this.loading=true;
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
    }, 10000);
  }
  public prepost:any;
  public post:any=[];
  public auxComments:any={
    "data":[{
      message:'',
      from:{
        name:'',
        id:0
      }
    }]
  };
  public auxLikes:any={
    data:[{
      message:''
    }]
  };
  getDatos(){
    this.loading=true;
    this.estadisticas=false;
    this.nPost=0;
    this.nComentarios=0;
    this.nMegusta=0;
    this.Facebook_friends=[];
    //https://graph.facebook.com/v2.12/me/comments?access_token=
    this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token='+this.user.authToken)
    //this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token=EAAEDPpwcvQYBALnczQimSVo7RystX6qXafgUeuIyQi6PYKZCO0q7dRCMxjhscQGgwg5KY9Rh4F1kBFNKRZC1vzgUP9dxCZCGxG9S9qe1lRu4eT7QuuUQZAuAnuIRqHSMuE4ZCb0wp4pIfZC6BymD0Ut6Md6MkrOw7bxPxadG0V00awTq8CVDl8B9tOD8zw9xEjMN1D1quVbgZDZD')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.post=[];
              this.prepost=data;
              var next=this.prepost.posts.paging.next;
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
              //this.getEstadisticas();
              this.paging(next);
              this.loading=false;
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading=false;

             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
  }
  usuariosComment(){
    for (var i = 0; i < this.post.length; ++i) {
      for (var j = 0; j < this.post[i].comments.data.length; ++j) {
        if(this.post[i].comments.data[j].from.name!='') {
          console.log(this.post[i].comments.data[j].from.name);
          if(this.post[i].comments.data[j].from.name!=undefined && this.post[i].comments.data[j].from.id!=undefined) {
            this.Facebook_friends.push({
              usuario:this.post[i].comments.data[j].from.name,
              facebook_id:this.post[i].comments.data[j].from.id,
            });
          }
        }
      }   
    }
    console.log(this.Facebook_friends);
  }
  usuariosLike(){
    for (var i = 0; i < this.post.length; ++i) {
      for (var j = 0; j < this.post[i].likes.data.length; ++j) {
        if(this.post[i].likes.data[j].name!='') {
          console.log(this.post[i].likes.data[j].name);
          if(this.post[i].likes.data[j].name!=undefined && this.post[i].likes.data[j].id!=undefined) {
            this.Facebook_friends.push({
              usuario:this.post[i].likes.data[j].name,
              facebook_id:this.post[i].likes.data[j].id,
            });
          }
        }
      }   
    }
    console.log(this.Facebook_friends);
  }
  removeDuplicates(originalArray, prop) {
     var newArray = [];
     var lookupObject  = {};

     for(var i in originalArray) {
        lookupObject[originalArray[i][prop]] = originalArray[i];
     }

     for(i in lookupObject) {
         newArray.push(lookupObject[i]);
     }
      return newArray;
  }

  paging(url){
    setTimeout(()=>{
    this.http.get(url)
    //this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token=EAAEDPpwcvQYBALnczQimSVo7RystX6qXafgUeuIyQi6PYKZCO0q7dRCMxjhscQGgwg5KY9Rh4F1kBFNKRZC1vzgUP9dxCZCGxG9S9qe1lRu4eT7QuuUQZAuAnuIRqHSMuE4ZCb0wp4pIfZC6BymD0Ut6Md6MkrOw7bxPxadG0V00awTq8CVDl8B9tOD8zw9xEjMN1D1quVbgZDZD')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              var next='';
              this.prepost=data;
              //console.log(this.prepost.length);
              //if(this.prepost.length>0){
                if( this.prepost.paging.hasOwnProperty('next') ) {
                 next=this.prepost.paging.next;
                }
              //}
              
              this.prepost=this.prepost.data;
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
              if(next!='') {
                this.paging(next);
              }else{
                setTimeout(()=>{
                this.startEstadisticas();
                }, 1000);
              }
              
              
              this.loading=false;
           },
           msg => { // Error
             
             console.log(msg);
             this.loading=false;

             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
    }, 1000);
  }
  startEstadisticas(){
    console.log(this.post);
    console.log(this.Facebook_friends);
    console.log(JSON.stringify(this.post));
    console.log(JSON.stringify(this.Facebook_friends));
    this.usuariosComment();
    setTimeout(()=>{
      this.usuariosLike();
     }, 1000);
    setTimeout(()=>{

      this.Facebook_friends = this.removeDuplicates(this.Facebook_friends, "facebook_id");
      console.log(this.Facebook_friends);
     }, 2000);
    setTimeout(()=>{
      this.getEstadisticas();
     }, 2500);
    
  }


  getPagina(){
    this.loading=true;
    this.estadisticas=false;
    this.nPost=0;
    this.nComentarios=0;
    this.nMegusta=0;
    //this.Facebook_friends=[];
    //https://graph.facebook.com/v2.12/me/comments?access_token=
    this.http.get('https://graph.facebook.com/v2.12/'+this.pagina+'?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token='+this.token)
    //this.http.get('https://graph.facebook.com/v2.12/me?fields=posts{from,message,comments{message,from},likes{pic_small,username,name}}&access_token=EAAEDPpwcvQYBALnczQimSVo7RystX6qXafgUeuIyQi6PYKZCO0q7dRCMxjhscQGgwg5KY9Rh4F1kBFNKRZC1vzgUP9dxCZCGxG9S9qe1lRu4eT7QuuUQZAuAnuIRqHSMuE4ZCb0wp4pIfZC6BymD0Ut6Md6MkrOw7bxPxadG0V00awTq8CVDl8B9tOD8zw9xEjMN1D1quVbgZDZD')
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
              this.post=[];
              this.prepost=data;
              var next=this.prepost.posts.paging.next;
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
              this.paging(next);
              
              this.loading=false;
           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading=false;

             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
  }

  signInWithFB(): void {
    this.loading=true;
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
  private usr: SocialUser;
  private loggedIn: boolean;

  public nComentarios=0;
  public nMegusta=0;
  public nPost=0;
  public n1Comentarios=0;
  public n2Comentarios=0;
  public n3Comentarios=0;
  public n1Megusta=0;
  public n2Megusta=0;
  public n3Megusta=0;
  public datosEstadisticas:any;
  getDatos2(){
    //
    this.loading=true;
    this.estadisticas=false;
    this.nPost=0;
    this.nComentarios=0;
    this.nMegusta=0;
    this.Facebook_friends=[];
    this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/posts')
        .toPromise()
         .then(
           data => { // Success
               this.loading=false;
               this.photoUrl='http://vivomedia.com.ar/assets/1.png';
               this.name='usuario';
               this.email='usuario@correo.com';
              console.log(data);
              this.post=[];
              this.prepost=data;
              this.Facebook_friends=this.prepost.Facebook_friends;
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
              this.getEstadisticas();

           },
           msg => { // Error
             console.log(msg);
             console.log(msg.error.error);
             this.loading=false;
             if(msg.status == 400 || msg.status == 401){ 
                  
                  this.showToast('warning', 'Warning!', msg.error.error);
              }
              else { 
                  this.showToast('error', 'Erro!', msg.error.error);
              }
           }
         );
  }

  public getEstadisticas(){
              for (var a = 0; a < this.post.length; a++) {
                  this.nPost++;
                  for (var b = 0; b < this.post[a].comments.data.length; b++) {
                    if(this.post[a].comments.data[0].from.name!='') {
                      this.nComentarios++;
                    }
                  }
                  for (var c = 0; c < this.post[a].likes.data.length; c++) {
                    if(this.post[c].likes.data[0].name!='') {
                      this.nMegusta++;
                    }
                  }
                }
              for (var e = 0; e < this.Facebook_friends.length; e++) {
                this.Facebook_friends[e].nComentarios=0;
                this.Facebook_friends[e].nMegusta=0;
                for (var i = 0; i < this.post.length; i++) {
                  for (var j = 0; j < this.post[i].comments.data.length; j++) {
                    if(this.post[i].comments.data[j].from.name==this.Facebook_friends[e].usuario) {
                      this.Facebook_friends[e].nComentarios++;
                    }
                  }
                  for (var k = 0; k < this.post[i].likes.data.length; k++) {
                    if(this.post[i].likes.data[k].name==this.Facebook_friends[e].usuario) {
                      this.Facebook_friends[e].nMegusta++;
                    }
                  }
                }
              }
              var com:any=[];
              var lik:any=[];
              for (var i = 0; i < this.Facebook_friends.length; ++i) {
                com.push({
                    usuario:this.Facebook_friends[i].usuario,
                    n:this.Facebook_friends[i].nComentarios,
                  });
                lik.push({
                    usuario:this.Facebook_friends[i].usuario,
                    n:this.Facebook_friends[i].nMegusta,
                  });
              }
              com.sort((a, b) => b.n - a.n);
              lik.sort((a, b) => b.n - a.n);
              
              console.log(com);
              console.log(lik);

              this.datosEstadisticas={
                nPost:this.nPost,
                nComentarios:this.nComentarios,
                nMegusta:this.nMegusta,
                n1Comentarios:com[0],
                n2Comentarios:com[1],
                n3Comentarios:com[2],
                n1Megusta:lik[0],
                n2Megusta:lik[1],
                n3Megusta:lik[2],
                com:com,
                lik:lik
              }
              console.log(this.datosEstadisticas);
              this.estadisticas=true;
              this.cdRef.detectChanges();
  }
  public getEstadisticas2(){
              for (var a = 0; a < this.post.length; a++) {
                  this.nPost++;
                  for (var b = 0; b < this.post[a].comments.data.length; b++) {
                    this.nComentarios++;
                  }
                  for (var c = 0; c < this.post[a].likes.data.length; c++) {
                    this.nMegusta++;
                  }
                }
              

              this.datosEstadisticas={
                nPost:this.nPost,
                nComentarios:this.nComentarios,
                nMegusta:this.nMegusta,
                n1Comentarios:0,
                n2Comentarios:0,
                n3Comentarios:0,
                n1Megusta:0,
                n2Megusta:0,
                n3Megusta:0,
                com:[],
                lik:[]
              }
              console.log(this.datosEstadisticas);
              this.estadisticas=true;
              this.cdRef.detectChanges();
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
