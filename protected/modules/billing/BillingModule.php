<?php

class BillingModule extends CWebModule
{

	public $defaultController = 'default';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'billing.models.*',
			'billing.components.*',
		));

		$robo_data = include __DIR__ . '/config/robokassa.php';

		CMap::mergeArray(Yii::app()->params, (array)$robo_data);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
		
			if(
				!($controller->id === 'tariff' && $action->id === 'settings')
					&&
				!($controller->id === 'default' && $action->id === 'license')
			) {
				$info = Yii::app()->db->createCommand('SHOW TABLES LIKE \'{{billing}}\'')->queryAll();

				if(!count($info)) {
					
					if(Webadmins::checkAccess('websettings_edit')) {
						
						$controller->redirect(array('/billing/tariff/settings'));
					}
					else {
						throw new CHttpException(404, 'Модуль не установлен админом');
					}
				}
			}
			
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}