import { Injectable } from '@angular/core';

@Injectable()
export class RutaBaseService {

	//Local freddy
	//public api_base = 'http://localhost/gitHub/cruce/';
	//public images_base = 'http://localhost/gitHub/cruce/images_uploads/';

	//Local stalin
	//public api_base = 'http://localhost/cruce/';
	//public images_base = 'http://localhost/cruce/images_uploads/';

	//Remoto
	public api_base = 'http://vivomedia.com.ar/vivoindex/';
	public images_base = 'http://vivomedia.com.ar/vivoindex/images_uploads/';

	constructor() { }

	getRutaApi(){
		return this.api_base;
	}

	getRutaImages(){
		return this.images_base;
}

}
