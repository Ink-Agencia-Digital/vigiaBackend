import { ConjuntosServiceService } from './../../_services/conjuntos-service.service';
import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { LoginService } from 'src/app/_services/login.service';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';

@Component({
  selector: 'app-bloques-apartamentos',
  templateUrl: './bloques-apartamentos.component.html',
  styleUrls: ['./bloques-apartamentos.component.scss']
})
export class BloquesApartamentosComponent implements OnInit {

  displayedColumns: string[] = ['id', 'name', 'tower_id'];
  dataSource;
  infoConjunto;
  tower;
  constructor(
    private loginService: LoginService,
    private router: Router,
    private conjuntoS: ConjuntosServiceService) {
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
    this.infoConjunto = this.loginService.desencryptarData();
    this.infoConjunto.forEach(element => {
      this.conjuntoS.getTowersComplex(element.id).subscribe( (towerInf: any) => {
        //console.log(towerInf.data);
        this.tower = towerInf.data;
        towerInf.data.forEach(element => {
          this.dataSource = element.apartments;
          
        });
        console.log(this.dataSource);
      });
    });
  }

}
