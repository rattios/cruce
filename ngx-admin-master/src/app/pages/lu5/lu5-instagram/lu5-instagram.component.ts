import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';

// Mis imports
import { RouterModule, Routes, Router, ActivatedRoute } from '@angular/router';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

import { RutaBaseService } from '../../../services/ruta-base/ruta-base.service';

import { FormBuilder, FormArray, FormGroup, Validators  } from '@angular/forms';

import { ToasterService, ToasterConfig, Toast, BodyOutputType } from 'angular2-toaster';
import 'style-loader!angular2-toaster/toaster.css';


declare const $: any;
declare var google: any;

@Component({
  selector: 'ngx-lu5-instagram',
  styleUrls: ['./lu5-instagram.component.scss'],
  templateUrl: './lu5-instagram.component.html',
})
export class Lu5InstagramComponent implements OnInit{

  
  

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
  public isLogin= true;

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
           public fb: FormBuilder)
  {

  	this.myFormAgregar = this.fb.group({
        nombre: ['', [Validators.required]],
        imagen: ['', [Validators.required]]
      });
  }

  ngOnInit() {
    
  }
  public response:any;
  loginInstagram(){
    /*var send={
      client_id:'007b9e3f680b41a5a2e965740b6ecf61',
      redirect_uri:'http://vivomedia.com.ar',
      response_type:'code'
    };
    this.http.post('https://api.instagram.com/oauth/authorize/?client_id=007b9e3f680b41a5a2e965740b6ecf61&redirect_uri=http://vivomedia.com.ar&response_type=code',send)
         .toPromise()
         .then(
           data => { // Success
              console.log(data);
             
           },
           msg => { // Error
             console.log(msg);
           }
         );*/

    //window.location.href="https://api.instagram.com/oauth/authorize/?client_id=007b9e3f680b41a5a2e965740b6ecf61&redirect_uri=http://vivomedia.com.ar/demoIndicadores/#/pages/lu5/instagram&response_type=code";
    window.open("https://api.instagram.com/oauth/authorize/?client_id=876f8d74735b4399ab0b7ece2e08262f&redirect_uri=http://vivomedia.com.ar/indicadores/instagram&response_type=code&scope=public_content+follower_list+comments+relationships+likes");
    this.isLogin= false;
  }
  public datosInstagram:any;
  public token:any;
  acceder(){
    this.http.get('http://vivomedia.com.ar/vivoindex/cruceAPI/public/instagram/1')
         .toPromise()
         .then(
           data => { // Successhttps://api.instagram.com/oauth/access_token
              console.log(data);
              this.datosInstagram=data;
              var cabeza= new HttpHeaders();
              cabeza.append("Authorization","Basic Og==");
              var send={
                client_id: '876f8d74735b4399ab0b7ece2e08262f',
                client_secret: '300280bbb08e41afbb8ac010e37aa1f4',
                grant_type: 'authorization_code',
                redirect_uri: 'http://vivomedia.com.ar/indicadores/instagram',
                code: this.datosInstagram.code

              }
              this.http.post('https://api.instagram.com/oauth/access_token',send,{
                headers: cabeza
              })
               .toPromise()
               .then(
                 data => { // Success
                    console.log(data);
                    this.token=data;
                    this.http.put('http://vivomedia.com.ar/vivoindex/cruceAPI/public/login/instagram/1',this.token)
                     .toPromise()
                     .then(
                       data => { // Success
                          console.log(data);
                           alert('exito');
                       },
                       msg => { // Error
                         console.log(msg);
                       }
                     );
                   
                 },
                 msg => { // Error
                   console.log(msg);
                   alert('error en access_token');
                 }
               );

           },
           msg => { // Error
             console.log(msg);
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
