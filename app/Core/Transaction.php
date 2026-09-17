<?php

namespace app\Core;

use app\Core\ConexionBD; 

class Transaction{

    protected $conexion;


	public function __construct()
	{
        //$this->conexion = new ConexionBD();
		$this->conexion = ConexionBD::get_instance();
	}
	
	public function startTransaction()
    {
        $this->conexion->query("START TRANSACTION") or die ($this->conexion->error());
    }

	public function commit()
    {
        $this->conexion->query("COMMIT") or die ($this->conexion->error());
    }

	public function rollback()
    {
        $this->conexion->query("ROLLBACK") or die ($this->conexion->error());
    }

	public function closeConnection()
    {
		$this->conexion->close_conexion();
	}

}