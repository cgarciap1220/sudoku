<?php


class Conexion
{
    private $servidor = "DESKTOP-JN48EGH";
    private $baseDatos = "sudoku";
    private $usuario = "sa";
    private $contrasenna = "@dmin2020**";

    public function __construct()
    {
    }

    public function conectar()
    {
        try
        {
            $serverName = $this->servidor;
            $connectionOptions = array("Database"=>$this->baseDatos,
                "Uid"=>$this->usuario, "PWD"=>$this->contrasenna);
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if($conn == false){
                var_dump(sqlsrv_errors());
            }
            return $conn;
        }
        catch(Exception $e)
        {
            echo("Error!");
        }
    }

    public function desconectar()
    {
        sqlsrv_close();
    }

    public function insertarResultado($matrix){
        $cnx = $this->conectar();
        $sql = "INSERT INTO [sudoku].[dbo].[resultado]
            (matrix) VALUES ('$matrix');";
        sqlsrv_query($cnx,$sql);
    }
    public function actualizarResultado($matrix,$id){
        $cnx = $this->conectar();
        $sql = "update [sudoku].[dbo].[resultado] set matrix =('$matrix')
            where idResultado = $id;";
        sqlsrv_query($cnx,$sql);
    }

    public function obtenerResultado(){
        $cnx = $this->conectar();
        $id = 0;
        $sql = "Select max(idResultado) from [sudoku].[dbo].[resultado]";
        $result = sqlsrv_query($cnx,$sql);
        while($resultado = sqlsrv_fetch_array( $result )) {
            $id = $resultado[0];
        }
        return $id;

    }
    public function insertarMovimientos($matrixInicial,$matrixFinal,$id){
        $cnx = $this->conectar();
        $sql = "INSERT INTO [sudoku].[dbo].[movimientos]
            (movInicial,movFinal,idResultado) 
            VALUES ('$matrixInicial','$matrixFinal', '$id');";
        sqlsrv_query($cnx,$sql);
    }

    public function obtenerMovimientos($idResultado){
        $arr = array();
        $cnx = $this->conectar();
        $id = 0;
        $sql = "Select movFinal from [sudoku].[dbo].[movimientos]
                where idResultado = $idResultado";
        $result = sqlsrv_query($cnx,$sql);
        while($resultado = sqlsrv_fetch_array( $result )) {

            array_push($arr,json_decode($resultado[0]));

        }
        return $arr;

    }
}

