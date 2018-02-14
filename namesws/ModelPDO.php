<?php

/**
 * Gestiona la connexió amb una base de dades MYSQL a través de la PDO.
 * Les classes que necessitin fer servir la base de dades només han d'extendre
 * d'aquesta i cridar a $this->getDBO(); per ja obtenir el objecte preparat.
 * 
 * @see http://php.net/manual/en/book.pdo.php
 *
 * @author Guillem Cuberes
 */
class ModelPDO {

	/**
	 * IP o nom de domini del servidor
	 * @var string
	 */
	private $host = "localhost";
	
	/**
	 * Nom de la base de dades
	 * @var string
	 */
	private $db = "namesws";
	
	/**
	 * Nom d'usuari
	 * @var string 
	 */
	private $usuari = "root";
	
	/**
	 * Contrasenya
	 * @var string
	 */
	private $contrasenya = "destino";
	
	/**
	 * Desa el objecte amb la connexió per a controlar que només n'hi hagi una
	 * 
	 * @var PDO
	 */
	private static $DBO;

	/**
	 * Torna l'objecte necessari per a treballar amb la base dedades.
	 * Controla el fet de que només es faci una connexió.
	 * 
	 * @return PDO
	 */
	public function getDBO() {

		if (!self::$DBO) {
			self::$DBO = $this->connect();
		}

		return self::$DBO;
	}

	/**
	 * Connecta a la base de dades
	 * @return PDO
	 */
	private function connect() {
		
		//Connecta
		$oDB = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->usuari, $this->contrasenya);

		//Activa el llançament d'excepcions per a que no peti en silenci
		$oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Treballa amb UTF8
		$oDB->query("SET NAMES utf8");

		return $oDB;
	}
        
        function getDb() {
            return $this->db;
        }

}
