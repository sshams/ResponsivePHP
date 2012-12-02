<?php

require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('_libs/SQL.php');
require_once ('model/connections/MScape.php');

class UserProxy extends Proxy implements IProxy {
	
	const NAME = "UserProxy";
	private $database;
	private $connection;
	private $recordset;
	private $row;
	
	public function __construct() {
		parent::__construct(self::NAME, null);
		$this->database = MScape::$database;
		$this->connection = MScape::getConnection();
		
		date_default_timezone_set('Asia/Dubai');
	}
	
	public function validate() {
		$xid = -1;
		if(isset($_GET['xid'])) {
			$xid = $_GET['xid'];
		}
		
		$query_rsUser = sprintf("SELECT * FROM `user` WHERE xid = %s", SQL::GetSQLValueString($xid, "text"));
		$this->recordset = mysql_query($query_rsUser, $this->connection) or die(mysql_error() . " " . $query_rsUser);
		$this->row = mysql_fetch_assoc($this->recordset);
		
		return mysql_num_rows($this->recordset) > 0 ? true : false;
	}
	
	public function is_answer() {
		return $this->row['answer'] != "" ? true : false;
	}
	
	public function is_location() {
		$query_rsUser = "SELECT * FROM `user` WHERE location = 1";
		$rsUser = mysql_query($query_rsUser, $this->connection) or die(mysql_error() . " " . $query_rsUser);
		$row_rsUser = mysql_fetch_assoc($rsUser);
		$totalRows_rsUser = mysql_num_rows($rsUser);
		
		return $totalRows_rsUser < 1 ? true : false;
	}
	
	public function update($answer, $location) {
		$updateSQL = sprintf("UPDATE `user` SET answer=%s, location=%s, `timestamp`=%s WHERE user_id=%s",
                     SQL::GetSQLValueString($answer, "text"),
                     SQL::GetSQLValueString($location, "int"),
                     SQL::GetSQLValueString(date('Y-m-d H:i:s'), "date"),
                     SQL::GetSQLValueString($this->row['user_id'], "int"));

  		$Result1 = mysql_query($updateSQL, $this->connection) or die(mysql_error() . " " . $updateSQL);
	}
	
	public function send_mail($location) {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From: Marlboro <marlboro@be-1st.net>' . "\r\n";
		mail($this->row['email'] , "The exclusive F1 MScape experience is almost yours", file_get_contents("view/templates/emails/" . $location . ".html"), $headers);
	}
	
	public function reset() {
		$updateSQL = sprintf("UPDATE `user` SET answer=%s, location=%s, `timestamp`=%s WHERE user_id=%s",
                   SQL::GetSQLValueString("", "text"),
                   SQL::GetSQLValueString(NULL, "int"),
                   SQL::GetSQLValueString(NULL, "date"),
                   SQL::GetSQLValueString($this->row['user_id'], "int"));

  		$Result1 = mysql_query($updateSQL, $this->connection) or die(mysql_error() . " " . $updateSQL);
	}
	
	public function generate() {
		$query_rsUser = "SELECT * FROM `user` WHERE xid IS NULL OR xid = ''";
		$query_limit_rsUser = sprintf("%s LIMIT %d, %d", $query_rsUser, 0, 100);
		$rsUser = mysql_query($query_limit_rsUser, $this->connection) or die(mysql_error() . " " . $query_limit_rsUser);
		$row_rsUser = mysql_fetch_assoc($rsUser);
		$totalRows_rsUser = mysql_num_rows($rsUser);
		
		if ($totalRows_rsUser > 0) {
			echo '<meta http-equiv="refresh" content="2">';
			do { 
				$xid = md5($row_rsUser['user_id'] . $row_rsUser['email']);
				$updateSQL = sprintf("UPDATE `user` SET xid=%s WHERE user_id=%s",
                       SQL::GetSQLValueString($xid, "text"),
                       SQL::GetSQLValueString($row_rsUser['user_id'], "int"));

  				$Result1 = mysql_query($updateSQL, $this->connection) or die(mysql_error() . " " . $updateSQL);
  				echo $xid . "<br />";
    		} while ($row_rsUser = mysql_fetch_assoc($rsUser)); 
		} else {
			echo "XIDs Generation Done";
		}
	}
	
}

?>