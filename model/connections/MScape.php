<?php

class MScape {
	
	public static $database;
	private static $hostname;
	private static $username;
	private static $password;
	private static $connection;
	
	public static function getConnection() {
		
		self::$hostname = "127.0.0.1";
		
		if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "10.244.153.90") {
			self::$username = "root";
			self::$password = "";
			self::$database = "MScape";
		} else {
			self::$username = "be1st_mscape";
			self::$password = "-LKg#@C#TdSJ";
			self::$database = "be1st_mscape";
		}
		
		if(!isset(self::$connection)){
			self::$connection = mysql_connect(self::$hostname, self::$username, self::$password) or trigger_error(mysql_error(), E_USER_ERROR);
			mysql_select_db(self::$database, self::$connection);
			mysql_query("SET NAMES utf8");
		}
		
		return self::$connection;
	}
}

?>