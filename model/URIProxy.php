<?php

require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('ApplicationFacade.php');

class URIProxy extends Proxy implements IProxy {
	
	const NAME = "URIProxy";
	
	const HOME = '/';
	CONST RESET = 'reset';
	CONST GENERATE = 'generate';

	public function __construct() {
		parent::__construct(self::NAME, isset($_SERVER['PATH_INFO']) ? explode("/", trim($_SERVER['PATH_INFO'], "/")) : self::HOME);
	}
	
}
?>