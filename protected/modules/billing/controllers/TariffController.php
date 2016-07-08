<?php
/**
 * Контроллер тарифов
 *
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
*/
class TariffController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		$model=new Tariff;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tariff']))
		{
			$model->attributes=$_POST['Tariff'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tariff']))
		{
			$model->attributes=$_POST['Tariff'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		$model=new Tariff('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tariff']))
			$model->attributes=$_GET['Tariff'];

		$config = Config::getCfg();

		if(isset($_POST['Config']))
		{
			$config->attributes=$_POST['Config'];
			if($config->save())
				$this->redirect(array('admin'));
		}

		$this->render('admin',array(
			'model'=>$model,
			'config' => $config
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionSettings()
	{
		if(!Webadmins::checkAccess('websettings_edit'))
			throw new CHttpException(403, 'У Вас недостаточно прав');

		$isInstalled = count(Yii::app()->db->createCommand('SHOW TABLES LIKE \'{{billing}}\'')->queryAll());
			
		if(Yii::app()->request->isPostRequest)
		{
			if(!$isInstalled && isset($_POST['robokassa_license'])) {

				$file = __DIR__ . '/../data/update.sql';
				$cmd = explode(';', file_get_contents($file));

				try {
					foreach($cmd AS $sql) {

						$sql = trim($sql);
						if(!$sql) continue;

						Yii::app()->db->createCommand(str_replace('%prefix%_', Yii::app()->db->tablePrefix, $sql))->execute();
					}
					Yii::app()->cache->flush();
				}
				catch(Exception $e) {
					$this->render('//site/error', array(
						'code' => '',
						'message' => 'Произошла ошибка: ' . $e->getMessage(),
					));
					Yii::app()->end();
				}
				
				$isInstalled = TRUE;
			}
		
			$file = __DIR__ . '/../config/robokassa.php';

			$data = '<?php return array(' . PHP_EOL;
			$data .= '\'robokassa_login\' => \''.CHtml::encode($_POST['robokassa_login']).'\',' . PHP_EOL;
			$data .= '\'robokassa_pass1\' => \''.CHtml::encode($_POST['robokassa_pass1']).'\',' . PHP_EOL;
			$data .= '\'robokassa_pass2\' => \''.CHtml::encode($_POST['robokassa_pass2']).'\',' . PHP_EOL;
			$data .= '\'robokassa_testing\' => '.(isset($_POST['robokassa_testing']) ? 'TRUE' : 'FALSE').',);' . PHP_EOL;

			if(!file_put_contents($file, $data)) {
				$this->render('/site/error', array(
					'code' => '',
					'message' => 'Недостаточно прав для записи настроек в файл <b>'.realpath($file).'</b>.',
				));
			}

			foreach($_POST AS $k => $v) {
				Yii::app()->params[$k] = $v;
			}
		}

		$this->render('settings', array(
			'installed' => $isInstalled,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tariff::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tariff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
