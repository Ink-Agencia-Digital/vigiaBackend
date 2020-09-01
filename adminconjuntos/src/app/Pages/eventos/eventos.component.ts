import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/_services/login.service';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';
import { MatDialog } from '@angular/material/dialog';
import { DetalleviewComponent } from './detalleview/detalleview.component';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-eventos',
  templateUrl: './eventos.component.html',
  styleUrls: ['./eventos.component.scss']
})
export class EventosComponent implements OnInit {


  displayedColumns: string[] = ['id', 'event', 'start', 'end', 'user', 'location', 'aprovedEstado', 'acciones'];
  dataSource;
  infoConjunto;
  tower;
  constructor(
    private loginService: LoginService,
    private router: Router,
    private conjuntoS: ConjuntosServiceService,
    private dilog: MatDialog,
    private snackBar: MatSnackBar,) {
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

    this.conjuntoS.var.subscribe(response => {

      this.snackBar.open(response, 'OK', { duration: 5000 });

      this.infoConjunto = this.loginService.desencryptarData();
      this.infoConjunto.forEach(element => {
        this.conjuntoS.getComplexEvents(element.id).subscribe((towerInf: any) => {
          let dto = towerInf.data;
          this.tower = dto;
          this.dataSource = dto;
          console.log(this.dataSource);
        });
      });

    });

    this.infoConjunto = this.loginService.desencryptarData();
    this.infoConjunto.forEach(element => {
      this.conjuntoS.getComplexEvents(element.id).subscribe((towerInf: any) => {
        let dto = towerInf.data;
        this.tower = dto;
        this.dataSource = dto;
        console.log(this.dataSource);
      });
    });

  }

  abrirDetalle(obj?: any) {
    const consul = obj != null ? obj : new Object();
    this.dilog.open(DetalleviewComponent, {
      width: '500px',
      data: consul
    });
  }

}
