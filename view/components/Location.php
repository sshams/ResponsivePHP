<?php

class Location {
	
	public function getLocation($id="") {
		echo file_get_contents("view/templates/index" . $id . ".html");
	}
	
	public function sorry() {
		echo file_get_contents("view/templates/sorry.html");
	}
	
	public function answered() {
		echo file_get_contents("view/templates/answered.html");
	}
	
	public function access_denied() {
		echo file_get_contents("view/templates/access_denied.html");
	}
}

?>