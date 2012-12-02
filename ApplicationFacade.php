<?php

require_once 'controller/commands/StartupCommand.php';
require_once 'controller/commands/UserCommand.php';
require_once 'controller/commands/ResetCommand.php';
require_once 'controller/commands/GenerateCommand.php';

class ApplicationFacade extends Facade implements IFacade {

	//for commands
	const STARTUP = "startup";
	const USER_COMMAND = "userCommand";
	const RESET_COMMAND = "resetCommand";
	const GENERATE_COMMAND = "generateCommand";
	
	const DEBUG = false;

	//for communication
	const LOCATION = "location";
	const SORRY = "sorry";
	const ANSWERED = "answered";
	const ACCESS_DENIED = "accessDenied";
	
	public static function getInstance() {
		if(parent::$instance == null) {
			parent::$instance = new ApplicationFacade();
		}
		
		return parent::$instance;
	}
	
	protected function initializeController() {
		parent::initializeController();
		$this->registerCommand(self::STARTUP, 'StartupCommand');
		$this->registerCommand(self::USER_COMMAND, 'UserCommand');
		$this->registerCommand(self::RESET_COMMAND, 'ResetCommand');
		$this->registerCommand(self::GENERATE_COMMAND, 'GenerateCommand');
	}

	public function startup() {
		$this->sendNotification(self::STARTUP);
	}

}

?>