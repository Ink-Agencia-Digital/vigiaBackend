import { LoginService } from './_services/login.service';
import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'vigia-AdmminConjuntos';

  userVarLog ;
  loginHide;
  infoConjunto;
  constructor(private login: LoginService, private router: Router) {

    if (!this.login.estaLogueado()){
      this.userVarLog = false;
      this.loginHide = false;
    }else{
      this.userVarLog = true;
      this.loginHide = true;
      this.infoConjunto = this.login.desencryptarData();
      console.log('informacion Conjunto:', this.infoConjunto);
    }

    this.login.var.subscribe( dt => {
      console.log(dt);
      this.userVarLog = true;
      this.loginHide = true;
      this.infoConjunto = this.login.desencryptarData();
      console.log('informacion Conjunto:', this.infoConjunto);
    });
    this.login.varLogOut.subscribe( dt => {
      console.log(dt);
      this.userVarLog = false;
      this.loginHide = false;
      sessionStorage.clear();
      this.router.navigate(['/login']);
    });
  }

  // tslint:disable-next-line: typedef
  cerrarse() {
    this.login.varLogOut.next('Cerrar Sesion');
  }
}
