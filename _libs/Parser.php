<?php

class Parser {

	public static function parse($template, $data){
		if($data) {
			foreach ($data as $key => $value){
				if(is_array($value)) {
				
				} else {
					$template = str_replace("{". $key . "}", $value, $template);
				}
			}
			return $template;
		}	

	}
	
}

?>