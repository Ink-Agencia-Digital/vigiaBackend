import { environment } from './../../../environments/environment';
import { LoginService } from './../../_services/login.service';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  usuario: string;
  contrasena: string;

  constructor(
    private login: LoginService,
    private router: Router) { }

  // tslint:disable-next-line: typedef
  ngOnInit() {
  }

  // tslint:disable-next-line: typedef
  iniciarsesion() {
    this.login.login(this.usuario, this.contrasena).subscribe( (log: any) => {
      sessionStorage.setItem(environment.TOKEN_NAME, log.access_token);
      sessionStorage.setItem('refresh_tk', log.refresh_token);

      const helper = new JwtHelperService();
      const token = sessionStorage.getItem(environment.TOKEN_NAME);

      this.login.logdataInfData(token).subscribe( dataUser => {
        console.log(dataUser);
        this.login.encryptarData(dataUser.complex_administrator);
        const rol = dataUser.roles[0];
        console.log(rol);
        if (rol.name === 'complex'){
          this.usuario = '';
          this.contrasena = '';
          this.login.var.next('Ingreso Exitoso');
          this.router.navigate(['/bloquesYapartamentos']);
        }else {
          console.log('error');
          this.usuario = '';
          this.contrasena = '';
        }
      });
    });
  }


}
