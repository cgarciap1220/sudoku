<?php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Origin: *");
include ('sudoku.php');
$sudoku = new Sudoku();

$resultado  = $sudoku->convertirMatrixJson($sudoku->crearSudoku());
$respuesta =  array('error'=> FALSE, 'sudoku'=> $resultado);
header('Content-Type: application/json');

echo json_encode($respuesta);