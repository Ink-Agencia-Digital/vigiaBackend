import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import * as CryptoJS from 'crypto-js';

const SECRET_KEY = 'UTF45qweRfgS';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  var = new Subject<string>();
  varLogOut = new Subject<string>();
  userVarLog = false;
  loginHide  = false;


  url = `/api/oauth/token`;
  basePath = `http://api.vigiaelectronic.com.co`;


  clientsec = `${environment.CLIENT_SECRET}`;
  clientid = `${environment.CLIENT_ID}`;


  constructor(private http: HttpClient, ) { }

  // tslint:disable-next-line: typedef
  login(usuario: any, contraseña: any){
    console.log(usuario, contraseña);
    const body = new HttpParams()
      .set('username', usuario)
      .set('password', contraseña)
      .set('client_secret', this.clientsec)
      .set('client_id', this.clientid)
      .set('grant_type', 'password');

    return this.http.post(this.basePath + this.url, body, {
      headers: new HttpHeaders()
        .set('Content-Type', 'application/x-www-form-urlencoded')
        .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

  // tslint:disable-next-line: typedef
  logdataInfData(infoUser: any){
    return this.http.get<any>(this.basePath + `/api/user`, {
      headers: new HttpHeaders()
        .set('X-Requested-With', 'XMLHttpRequest')
        .set('Authorization', 'Bearer ' + infoUser)
    });
  }

  // tslint:disable-next-line: typedef
  estaLogueado() {
    const token = sessionStorage.getItem(environment.TOKEN_NAME);
    return token != null;
  }

  encryptarData(dataConjunto: any){
    let encryptData = CryptoJS.AES.encrypt(JSON.stringify(dataConjunto), SECRET_KEY).toString();
    sessionStorage.setItem('infoConjunto', encryptData);
  }

  desencryptarData(){
    let infoConjunto = sessionStorage.getItem('infoConjunto');
    let bytes = CryptoJS.AES.decrypt(infoConjunto, SECRET_KEY);
    var obj = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
    return obj;
  }
}
