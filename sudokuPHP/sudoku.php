<?php
require('Conexion.php');

class Sudoku {

    private $matrix;
    private $conexion;

    public function __construct() {

        $this->matrix = array(
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0),
        );
        $this->conexion = new Conexion();

    }

    public function crearSudoku() {
        $this->matrix = $this->obtenerSudoku($this->matrix);
        $celdas = array_rand(range(0, 80), 30);
        $i = 0;
        foreach ($this->matrix as &$fila) {
            foreach ($fila as &$celda) {
                if (!in_array($i++, $celdas)) {
                    $celda = null;
                }
            }
        }
        $matrixFinal = json_encode($this->convertirMatrixJson($this->matrix));
        $this->conexion->insertarResultado($matrixFinal);
       // $_SESSION['idResultado']= "";
        return $this->matrix;
    }

    public function resolverSudoku($matrix, $idResultado) {

        $this->matrix = $this->obtenerSudoku($matrix, $idResultado );
        $matrixFinal = json_encode($this->convertirMatrixJson($this->matrix));
        $this->conexion->actualizarResultado($matrixFinal, $idResultado);
        return $this->matrix;

    }

    private function obtenerSudoku($matrix, $id = null) {
        while(true) {
            $opciones = array();
            foreach ($matrix as $filas => $fila) {
                foreach ($fila as $columnas => $celda) {
                    if (!empty($celda)) {
                        continue;
                    }
                    $posibilidades = $this->posibilidades($matrix, $filas, $columnas);

                    if (count($posibilidades) == 0) {
                        return false;
                    }
                    $opciones[] = array(
                        'filas' => $filas,
                        'columnas' => $columnas,
                        'posibilidades' => $posibilidades
                    );

                }

            }
            if (count($opciones) == 0) {
                return $matrix;
            }

            usort($opciones, array($this, 'ordenarOpciones'));

            if (count($opciones[0]['posibilidades']) == 1) {
                $matrix[$opciones[0]['filas']][$opciones[0]['columnas']] = current($opciones[0]['posibilidades']);

                continue;
            }

            foreach ($opciones[0]['posibilidades'] as $value) {
                $tmp = $matrix;
                $tmp[$opciones[0]['filas']][$opciones[0]['columnas']] = $value;
                if($id != null){
                    $this->guardarHistorial($matrix,$tmp,$id);
                }
                if ($result = $this->obtenerSudoku($tmp, $id)) {


                    return $result;
                }

            }

            return false;
        }
    }

    private function posibilidades($matrix, $filas, $columnas) {
        $valid = range(1, 9);
        $invalid = $matrix[$filas];
        for ($i = 0; $i < 9; $i++) {
            $invalid[] = $matrix[$i][$columnas];
        }
        $box_fila = $filas % 3 == 0 ? $filas : $filas - $filas % 3;
        $box_col = $columnas % 3 == 0 ? $columnas : $columnas - $columnas % 3;
        $invalid = array_unique(array_merge(
            $invalid,
            array_slice($matrix[$box_fila], $box_col, 3),
            array_slice($matrix[$box_fila + 1], $box_col, 3),
            array_slice($matrix[$box_fila + 2], $box_col, 3)
        ));
        $valid = array_diff($valid, $invalid);
        shuffle($valid);


        return $valid;
    }

    private function ordenarOpciones($a, $b) {
        $a = count($a['posibilidades']);
        $b = count($b['posibilidades']);
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }



    public function convertirMatrixJson($matrix){
        $matrixFinal = array();
        $matrixTemp = array(
            'y'=> '',
            'x'=> '',
            'value'=>''
        );
        for ($i = 0; $i < count($matrix); $i++){
            for ($j = 0; $j < count($matrix[$i]); $j++){
                $matrixTemp["y"]= $i;
                $matrixTemp["x"]= $j;
                if($matrix[$i][$j] != 0){
                    $matrixTemp["value"]= $matrix[$i][$j];
                }
                else{
                    $matrixTemp["value"]= null;
                }
                array_push($matrixFinal, $matrixTemp);
            }
            //$matrixFinal[$i] = $matrixTemp;
        }
        return $matrixFinal;
    }
    public function convertirJsonMatrix($matrix){
        $matrixFinal = array();

        for ($i = 0; $i < count($matrix); $i++){
            $matrixTemp = array();
            for ($j = 0; $j < count($matrix[$i]); $j++){

                if($matrix[$i][$j]->value != 0){
                    $valor = $matrix[$i][$j]->value;
                }
                else{
                    $valor = null;
                }
                array_push($matrixTemp,$valor );

            }
            array_push($matrixFinal, $matrixTemp);
        }
        return $matrixFinal;
    }

    public function guardarHistorial($matrixInicial, $matrixFinal, $id){
        $matrixInicial = json_encode($this->convertirMatrixJson($matrixInicial));
        $matrixFinal = json_encode($this->convertirMatrixJson($matrixFinal));
        $this->conexion->insertarMovimientos($matrixInicial,$matrixFinal, $id);
    }

    public function obtenerIdResultado(){
        $id = $this->conexion->obtenerResultado();
        return $id;
    }

    public function obtenerHistorial($idResultado){

        return $this->conexion->obtenerMovimientos( $idResultado);

    }

}

