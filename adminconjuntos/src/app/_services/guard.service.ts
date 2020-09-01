import { Router } from '@angular/router';
import { LoginService } from './login.service';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class GuardService{

  constructor(
    private loginService: LoginService,
    private router: Router
  ) { }

  // tslint:disable-next-line: typedef
  guardarPorDefecto(){
    sessionStorage.setItem('userVarLog', 'false');
  }


}
