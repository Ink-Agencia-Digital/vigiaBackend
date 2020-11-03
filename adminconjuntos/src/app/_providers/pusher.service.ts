import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

declare const Pusher: any;

@Injectable({
  providedIn: 'root'
})
export class PusherService {

  channel;

  constructor(public http: HttpClient) {
  }

  channelsuscribe(id: any){
    console.log('entre');
    let pusher = new Pusher('95f1508af6be62065450', {
      cluster: 'us2',
      encrypted: true,
    });
    this.channel = pusher.subscribe('chat.' + id);
  }

  init(){
    return this.channel;
  }

}
