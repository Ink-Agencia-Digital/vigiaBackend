import { ChatCompletoComponent } from './Pages/chat/chat-completo/chat-completo.component';
import { GuardService } from './_services/guard.service';
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './Pages/login/login.component';
import { Not404Component } from './Pages/not404/not404.component';
import { Not401Component } from './Pages/not401/not401.component';
import { BloquesApartamentosComponent } from './Pages/bloques-apartamentos/bloques-apartamentos.component';
import { EmpleadosComponent } from './Pages/empleados/empleados.component';
import { EventosComponent } from './Pages/eventos/eventos.component';
import { ResidentesComponent } from './Pages/residentes/residentes.component';
import { ChatComponent } from './Pages/chat/chat.component';
import { AsociarClienteComponent } from './Pages/asociar-cliente/asociar-cliente.component';

const routes: Routes = [
  {path: 'asociarClientes', component: AsociarClienteComponent},
  {path: 'chatCompleto', component:  ChatCompletoComponent},
  {path: 'chat', component:  ChatComponent},
  {path: 'residentes', component:  ResidentesComponent},
  {path: 'eventos', component:  EventosComponent},
  {path: 'empleados', component:  EmpleadosComponent},
  {path: 'bloquesYapartamentos', component:  BloquesApartamentosComponent},
  {path: 'not404', component:  Not404Component},
  {path: 'not401', component:  Not401Component},
  {path: 'login', component:  LoginComponent},
  {path: '',  redirectTo: 'login'  , pathMatch: 'full'},
  {path: '**',  redirectTo: 'not404'  , pathMatch: 'full'},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
