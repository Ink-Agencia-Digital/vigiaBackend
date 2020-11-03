import { PusherService } from './../../../_providers/pusher.service';
import { environment } from './../../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';
import { LoginService } from 'src/app/_services/login.service';

@Component({
  selector: 'app-chat-completo',
  templateUrl: './chat-completo.component.html',
  styleUrls: ['./chat-completo.component.scss']
})
export class ChatCompletoComponent implements OnInit {

  data: any;
  total: any;
  mensaje: Array<any>;
  page: any;
  usuarioActual: any;
  newMsg = '';


  constructor(
    private loginService: LoginService,
    private router: Router,
    private conjuntoS: ConjuntosServiceService,
    private route: ActivatedRoute,
    private pusher: PusherService
  ) {
    if (this.loginService.estaLogueado()) {
      const helper = new JwtHelperService();
      const token = sessionStorage.getItem(environment.TOKEN_NAME);

      if (!helper.isTokenExpired(token)) {
        this.loginService.logdataInfData(token).subscribe(usData => {

          const rol = usData.roles[0];
          const rolename: string = rol.name;

          if (rolename === 'complex') {
            console.log('entre bloques y apartamentos');
          } else {
            this.router.navigate([`/not401`]);
          }
        });
      }
    } else {
      this.router.navigate([`/login`]);
    }
  }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      if (params && params.info) {
        this.data = params.info;
        const temNum: number = +params.useract;
        this.usuarioActual = temNum;
        this.pusher.channelsuscribe(params.info);
        const channel = this.pusher.init();
        channel.bind('chat_event', data => {
          this.updateMsg(data);
        });
        this.conjuntoS.getchatsMSGUser(params.info).subscribe((dtres: any) => {
          this.total = dtres.meta;
          this.mensaje = dtres.data.reverse();
          const currentPage = this.total.current_page;
          this.page = currentPage + 1;
        });
      }
    });
  }

  updateMsg(data: any) {
    this.mensaje.push(data.message);
  }

  onScrollDown() {

  }

  onScrollUp() {
    setTimeout(() => {
      const nuevoArra = this.total.total;
      if (this.mensaje.length !== nuevoArra) {
        this.conjuntoS.getMessageOFPages(this.usuarioActual, this.page).subscribe((chatMsg: any) => {
          chatMsg.data.forEach(element => {
            this.mensaje.unshift(element);
          });
          this.page = this.page + 1;
        });
      }
    }, 1000);
  }

  enviarMsg() {
    this.conjuntoS.enviarMensajeChat(this.data, this.usuarioActual, this.newMsg).subscribe(res => {
      setTimeout(() => {
        this.newMsg = '';
      });
    });
  }

}
