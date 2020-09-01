import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/_services/login.service';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';

@Component({
  selector: 'app-residentes',
  templateUrl: './residentes.component.html',
  styleUrls: ['./residentes.component.scss']
})
export class ResidentesComponent implements OnInit {


  displayedColumns: string[] = ['id', 'apartments', 'name', 'lastname', 'email', 'ice', 'identification', 'phone'];
  dataSource;
  infoConjunto;
  tower;
  apartament;
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
      this.conjuntoS.getComplexResidents(element.id).subscribe((towerInf: any) => {
        console.log('redicentes:', towerInf);
        let dto = towerInf.data;
        this.dataSource = dto;
        dto.forEach(element => {
          console.log(element.apartments);
          this.apartament = element.apartments;
        });
      });
    });

  }

}
