<?php
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Origin: *");
include ('sudoku.php');
$sudoku = new Sudoku();
$json = file_get_contents('php://input');
$arr = json_decode($json);
$matrix = $sudoku->convertirJsonMatrix($arr);
$idResultado = $sudoku->obtenerIdResultado();
$resultado  = $sudoku->convertirMatrixJson($sudoku->resolverSudoku($matrix, $idResultado));
$historial  = $sudoku->obtenerHistorial($idResultado);
$respuesta =  array('error'=> FALSE, 'sudoku'=> $resultado, 'historial'=>$historial);
header('Content-Type: application/json');
echo json_encode($respuesta);