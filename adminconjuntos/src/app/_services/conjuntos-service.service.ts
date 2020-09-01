import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConjuntosServiceService {

  var = new Subject<string>();

  basePath = `http://api.vigiaelectronic.com.co`;

  constructor(private http: HttpClient, ) { }


  getComplexResidents(idComplex: any){
    return this.http.get<any>(this.basePath + `/api/complexes/${idComplex}/residents`, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }


  getComplexEmployes(idComplex: any){
    return this.http.get<any>(this.basePath + `/api/complexes/${idComplex}/employees`, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

  getTowersComplex(idComplex: any){
    return this.http.get<any>(this.basePath + `/api/complexes/${idComplex}/towers`, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

  getComplexEvents(idComplex: any){
    return this.http.get<any>(this.basePath + `/api/complexes/${idComplex}/reservations`, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

  updateEvento(estado: any, idReservacion: any){

    const body = new HttpParams()
    .set('aproved', estado);

    return this.http.put(this.basePath + `/api/reservations/${idReservacion}`, body, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

}
