import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ConjuntosServiceService } from 'src/app/_services/conjuntos-service.service';

@Component({
  selector: 'app-detalleview',
  templateUrl: './detalleview.component.html',
  styleUrls: ['./detalleview.component.scss']
})
export class DetalleviewComponent implements OnInit {

  consult: any;
  constructor(
    private dialogref: MatDialogRef<DetalleviewComponent>,
    @Inject(MAT_DIALOG_DATA) private data: any,
    private snackbar: MatSnackBar,
    private consjuntoS: ConjuntosServiceService) { }

  ngOnInit(): void {
    this.consult = this.data;
    console.log('data validate:', this.data);
  }

  rechazar(){
    let id = 2;
    this.consjuntoS.updateEvento(id, this.data.id).subscribe( responseDT => {
        console.log(responseDT);
        this.consjuntoS.var.next('estado Rechazado actualizado');
        this.cancelar();
    });
  }

  aprobar(){
    let id = 1;
    this.consjuntoS.updateEvento(id, this.data.id).subscribe( responseDT => {
        console.log(responseDT);
        this.consjuntoS.var.next('estado Rechazado actualizado');
        this.cancelar();
    });
  }

  cancelar() {
    this.dialogref.close();
  }

}
