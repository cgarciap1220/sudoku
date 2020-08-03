import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SudokuService {
  url = 'http://localhost/sudokuPHP/';
  constructor(public http: HttpClient) { }

  iniciar_sudoku()
  {
    console.log(this.http.get(this.url + 'iniciar.php'));
    return this.http.get(this.url + 'iniciar.php');
  }
  resolver_sudoku(matrix){
    // @ts-ignore
    return this.http.post(this.url + 'resolver.php', JSON.stringify(matrix));
  }

}
