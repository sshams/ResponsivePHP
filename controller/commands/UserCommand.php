<?php

require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('model/UserProxy.php');
require_once ('view/mediators/LocationMediator.php');
require_once ('view/components/Location.php');

class UserCommand extends SimpleCommand {
	
	public function execute(INotification $notification) {
		
		$this->facade->registerProxy(new UserProxy());
		$userProxy = $this->facade->retrieveProxy(UserProxy::NAME);
		
		$this->facade->registerMediator(new LocationMediator(new Location()));
		
		if($userProxy->validate()) {
			if(!ApplicationFacade::DEBUG && $userProxy->is_answer()) { //already answered
				$this->facade->sendNotification(ApplicationFacade::ANSWERED);
			} else {
				if($_REQUEST['answer'] == 2) { //true answer
					if($userProxy->is_location()) { //location 1 available
						$userProxy->update($_REQUEST['answer'], 1);
						if(!ApplicationFacade::DEBUG) $userProxy->send_mail(1);
						$this->facade->sendNotification(ApplicationFacade::LOCATION);
					} else { //location 1 full
						$userProxy->update($_REQUEST['answer'], 2);
						if(!ApplicationFacade::DEBUG) $userProxy->send_mail(2);
						$this->facade->sendNotification(ApplicationFacade::LOCATION, 2);
					}
				} else { //false answer
					$userProxy->update($_REQUEST['answer'], 0);
					$this->facade->sendNotification(ApplicationFacade::SORRY);
				}
			}
		} else {
			$this->facade->sendNotification(ApplicationFacade::ACCESS_DENIED);
		}

	}
}

?>