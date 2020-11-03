import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { NavigationExtras, Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { LoginService } from 'src/app/_services/login.service';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit {

  infoData: any;
  chatUsuarios: Array<any>;


  constructor(
    private loginService: LoginService,
    private router: Router,
    private conjuntoS: ConjuntosServiceService
  ) {
    if ( this.loginService.estaLogueado()) {
      const helper = new JwtHelperService();
      const token = sessionStorage.getItem(environment.TOKEN_NAME);

      if (!helper.isTokenExpired(token)) {
        this.loginService.logdataInfData(token).subscribe(usData => {

          const rol = usData.roles[0];
          const rolename: string  = rol.name;

          if (rolename === 'complex') {
            console.log('entre bloques y apartamentos');
          }else{
            this.router.navigate([`/not401`]);
          }
        });
      }
    }else{
      this.router.navigate([`/login`]);
    }
  }

  ngOnInit(): void {
    this.chatUsuarios = [];
    this.infoData = this.loginService.desencryptarDataUser();
    this.conjuntoS.getChats(this.infoData.id).subscribe( res => {
      console.log('respuesta', res);
      this.chatUsuarios = res.data;
    });
    console.log('info data:', this.infoData);
  }

  vermensaje(idChat: any){
    const NavigationExtras: NavigationExtras = {
      queryParams: {
        info: JSON.stringify(idChat),
        useract: this.infoData.id
      }
    };
    this.router.navigate(['/chatCompleto'], NavigationExtras);
  }

}
