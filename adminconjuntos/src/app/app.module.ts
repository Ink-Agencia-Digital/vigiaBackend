import { PusherService } from './_providers/pusher.service';
import { MaterialModule } from './material/material.module';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { LoginComponent } from './Pages/login/login.component';
import { Not404Component } from './Pages/not404/not404.component';
import { Not401Component } from './Pages/not401/not401.component';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BloquesApartamentosComponent } from './Pages/bloques-apartamentos/bloques-apartamentos.component';
import { EventosComponent } from './Pages/eventos/eventos.component';
import { EmpleadosComponent } from './Pages/empleados/empleados.component';
import { ResidentesComponent } from './Pages/residentes/residentes.component';
import { DetalleviewComponent } from './Pages/eventos/detalleview/detalleview.component';
import { LocationStrategy, HashLocationStrategy } from '@angular/common';
import { ChatComponent } from './Pages/chat/chat.component';
import { ChatCompletoComponent } from './Pages/chat/chat-completo/chat-completo.component';
import { AsociarClienteComponent } from './Pages/asociar-cliente/asociar-cliente.component';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    Not404Component,
    Not401Component,
    BloquesApartamentosComponent,
    EventosComponent,
    EmpleadosComponent,
    ResidentesComponent,
    DetalleviewComponent,
    ChatComponent,
    ChatCompletoComponent,
    AsociarClienteComponent
  ],
  entryComponents: [
    DetalleviewComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MaterialModule,
    FormsModule,
    HttpClientModule,
  ],
  providers: [
    PusherService,
    {provide: LocationStrategy, useClass: HashLocationStrategy}
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
