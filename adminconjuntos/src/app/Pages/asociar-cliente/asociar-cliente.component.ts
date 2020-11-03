import { environment } from './../../../environments/environment';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';
import { LoginService } from 'src/app/_services/login.service';

@Component({
  selector: 'app-asociar-cliente',
  templateUrl: './asociar-cliente.component.html',
  styleUrls: ['./asociar-cliente.component.scss']
})
export class AsociarClienteComponent implements OnInit {

  infoConjunto;
  tower;
  activarApartamentos = false;
  apartamentos;
  activarBusqueda = false;
  cedulaUser: any;
  resultadoUser: any;
  apartamentoID: any;

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
        console.log('informacion torre',towerInf.data);
        this.tower = towerInf.data;
      });
    });
  }

  tets(inf: any){
    if (inf.id !== null){
      this.activarApartamentos = true;
      this.apartamentos = inf.apartments;
    }
  }

  tets2(inf: any){
    if (inf.id !== null){
      this.apartamentoID = inf.id;
      this.activarBusqueda  = true;
    }
  }

  buscar(){
    console.log('Soy la cedula', this.cedulaUser);
    this.conjuntoS.UserbyCed(this.cedulaUser).subscribe( (resCed: any) =>{
      console.log('Respuesta del user por cedula', resCed);
      this.resultadoUser = resCed.data;
    });
  }

  Asociar(idUs: any){
    this.conjuntoS.asociarUsuario(idUs, this.apartamentoID).subscribe( (resCed: any) =>{
      console.log('Usuario Asociado', resCed);
    });
  }

  Desasociar(idUs: any){
    this.conjuntoS.desasociarUsuario(idUs, this.apartamentoID).subscribe( (resCed: any) =>{
      console.log('Usuario Desasociado', resCed);
    });
  }

}
