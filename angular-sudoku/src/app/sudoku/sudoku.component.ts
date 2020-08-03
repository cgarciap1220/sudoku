import { Component, OnInit } from '@angular/core';
import { SudokuService } from '../servicio/sudoku.service';

@Component({
  selector: 'app-sudoku',
  templateUrl: './sudoku.component.html',
  styleUrls: ['./sudoku.component.css']
})
export class SudokuComponent implements OnInit {
  matrixInicial: any [] = [];
  matrixFinal: any [] = [];

  constructor(public sdk: SudokuService) { }

  ngOnInit(): void {
    this.cargarSudoku();
  }
  cargarSudoku(){
    this.sdk.iniciar_sudoku().subscribe( resp => {
      const nuevaData = this.agrupar(resp['sudoku'], 9);
      this.matrixInicial.push(...nuevaData);
    });
  }

  resolverSudoku(){
    this.sdk.resolver_sudoku(this.matrixInicial).subscribe( resp => {
      const nuevaData = this.agrupar(resp['sudoku'], 9);
      this.matrixFinal.push(...nuevaData);
      const hist = resp['historial'][0];
    });
  }

  empezar(){
    this.matrixInicial = [];
    this.matrixFinal = [];
    this.ngOnInit();
  }

  private agrupar(arr: any = [], tamano: number) {
    const nuevoArreglo = [];
    for (let i = 0; i < arr.length; i = i + tamano) {
      nuevoArreglo.push(arr.slice(i, i + tamano));
    }
    return nuevoArreglo;
  }
}
