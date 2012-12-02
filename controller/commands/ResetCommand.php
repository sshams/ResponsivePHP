<?php

require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('model/UserProxy.php');

class ResetCommand extends SimpleCommand implements ICommand {
	
	public function execute(INotification $notification) {
	
		$this->facade->registerProxy(new UserProxy());
		$userProxy = $this->facade->retrieveProxy(UserProxy::NAME);

		if($userProxy->validate()) {
			$userProxy->reset();
			echo "reset done";
		}
	}
	
}

?>