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

  getChats(idUser: any){
    return this.http.get<any>(this.basePath + `/api/users/${idUser}/chats`, {
      headers: new HttpHeaders()
      .set('Content-Type', 'application/x-www-form-urlencoded')
      .set('X-Requested-With', 'XMLHttpRequest'),
    });
  }

  getchatsMSGUser(idchat: any) {
    console.log('entre y falle');
    return this.http.get<any[]>(this.basePath + `/api/chats/${idchat}/messages?page=1&orber_by=created_at&direction=desc`, {
      headers: new HttpHeaders()
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

  getMessageOFPages(idChat: any, idPage: any){
    return this.http.get<any[]>(this.basePath + `/api/chats/${idChat}/messages?page=${idPage}&orber_by=created_at&direction=desc`, {
      headers: new HttpHeaders()
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

  enviarMensajeChat(chatid: any, transmiterID: any, msg: any) {
    const body = new HttpParams()
      .set('chat_id', chatid)
      .set('message', msg)
      .set('sender_id', transmiterID);


    return this.http.post(this.basePath + `/api/messages`, body, {
      headers: new HttpHeaders()
        .set('Content-Type', 'application/x-www-form-urlencoded')
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

  UserbyCed(ced: any){
    return this.http.get<any[]>(this.basePath + `/api/users?query=identification|=|${ced}`, {
      headers: new HttpHeaders()
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

  asociarUsuario(userID: any, idapartamento: any) {
    const body = new HttpParams()
      .set('user_id', userID);


    return this.http.post(this.basePath + `/api/apartments/${idapartamento}/users`, body, {
      headers: new HttpHeaders()
        .set('Content-Type', 'application/x-www-form-urlencoded')
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

  desasociarUsuario(userID: any, idapartamento: any) {
    return this.http.delete(this.basePath + `/api/apartments/${idapartamento}/users/${userID}`, {
      headers: new HttpHeaders()
        .set('Content-Type', 'application/x-www-form-urlencoded')
        .set('X-Requested-With', 'XMLHttpRequest')
    });
  }

}
