<?php

class connect{
    private $servidor = "localhost";
    private $usuario = "root";
    private $contrasenia = "";
    private $connect;

    public function __construct(){
        try{
            $this->connect = new PDO("mysql:host=$this->servidor;dbname=album3",$this->usuario,$this->contrasenia);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            return "error".$e;
        }
    }

    public function ejecutar($sql){
        $this->connect->exec($sql);
        return $this->connect->lastInsertId();
    }

    public function consultar($sql){
        $sentencia = $this->connect->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

}


?>