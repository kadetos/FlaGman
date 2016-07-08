<?php
/**
 * Контроллер биллинга
 *
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
*/
class BillingController extends Controller
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

	public function actionBuy($server = 0, $tariff = 0, $days = 0, $auth = 0, $steamid = '', $password = '', $nickname = '', $email = '')
	{

		if(Yii::app()->request->isAjaxRequest)
			$this->layout = FALSE;

		if(!Config::getStatus()) {
			$this->render('/site/error', array(
				'code'		=> '',
				'message'	=> 'Система временно отключена администратором'
			));
			Yii::app()->end();
		}

		$model=new Billing('buy');

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST;
			if($model->save()) {

				$robo = new Robokassa();

				$this->render('buy2', array(
					'robo'		=> $robo->getForm($model),
					'model'		=> $model,
				));
				Yii::app()->end();
			}
		}

		$servers = Serverinfo::getAllServers(FALSE, TRUE);
		$tariffs = Tariff::getList(FALSE, ( $server ? $server : NULL ));

		if($server && !count($tariffs)) {
			$tariff = 0;
			$auth = 0;
		}

		$this->render('buy', array(
			'model'		=> $model,

			'server'	=> $server,
			'tariff'	=> $tariff,
			'days'		=> $days,
			'nick'		=> $nickname,
			'auth'		=> $auth,
			'steamid'	=> $steamid,
			'pwd'		=> $password,
			'email'		=> $email,

			'servers'	=> $servers,
			'tariffs'	=> $tariffs,
		));
	}

	public function actionUnban($id)
	{

		if(!Config::getStatus(FALSE)) {
			$this->render('/site/error', array(
				'code'		=> '',
				'message'	=> 'Система временно отключена администратором'
			));
			Yii::app()->end();
		}

		$ban = Bans::model()->findByPk($id);

		if($ban === NULL || $ban->ban_length == '-1') {
			throw new CHttpException(404, 'Бан не существует');
		}

		$model=new Billing('buy');

		$days = $ban->ban_length && $ban->ban_length < 1440 ? 1 : floor($ban->ban_length / 1440);

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(Yii::app()->request->isPostRequest)
		{
			//$model->attributes = $_POST;

			$model->tariff = '0';
			$model->days = $days;
			$model->server = 0;
			$model->steamid = $id;
			$model->nickname = $ban->player_nick;
			$model->auth = 'a';
			$model->password = '123456';

			$model->email = $_POST['email'];

			if($model->save()) {

				$robo = new Robokassa();

				$this->render('buy2', array(
					'robo'		=> $robo->getForm($model),
					'model'		=> $model,
				));
				Yii::app()->end();
			}
		}

		$this->render('unban', array(
			'model'		=> $model,
			'ban'		=> $ban,
			'days'		=> $days,
		));
	}

	public function actionResult() {

		$gate = new Robokassa();
		
		$field = $_POST[ $gate->getIdField() ];

		$model = Billing::model()->find(
			'`id` = :id AND `status` = :status',
			array(
				':id' => $field,
				':status' => Billing::STATUS_CREATED,
			)
		);

		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

		$result = $gate->resultUrl($model);
		if($gate->isSuccess()) {
			$model->status = Billing::STATUS_PAID;
			$model->desc = serialize($_POST);
			if(!$model->save())
				Yii::log("Ошибка сохранения оплаченного счета #{$model->id}", CLogger::LEVEL_ERROR);

			if($model->tariff === '0') {

				$model->ban->ban_length = '-1';
				$model->ban->expired = '1';
				if(!$model->ban->save(FALSE)) {
					Yii::log("Ошибка разбана #{$model->ban->bid}", CLogger::LEVEL_ERROR);
				}
			}
			else {

				$admin				= new Amxadmins('buy');
				$admin->username	= '';
				$admin->password	= $model->password;
				$admin->access		= $model->tariff1->flags;
				$admin->flags		= $model->auth;
				$admin->steamid		= $model->steamid;
				$admin->nickname	= $model->nickname;
				$admin->ashow		= '1';
				$admin->days		= $model->days;

				if($admin->save()) {

					$as = new AdminsServers;
					$as->admin_id = $admin->id;
					$as->server_id = $model->server;
					$as->custom_flags = $model->tariff1->flags;
					$as->use_static_bantime = 'no';

					if(!$as->save()) {
						Yii::log("Ошибка привязки админа (#{$admin->id}) к серверу #{$model->server}", CLogger::LEVEL_ERROR);
					}
				}
				else {
					Yii::log("Ошибка добавления админа #{$model->id}", CLogger::LEVEL_ERROR);
				}
			}
		}

		exit($result);
	}

	public function actionSuccess() {

		$this->render('success',array(
			'success'=>TRUE,
		));
	}

	public function actionFail() {

		$this->render('success',array(
			'success'=>FALSE,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
		
		$model=new Billing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Billing']))
			$model->attributes=$_GET['Billing'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Billing::model()->findByPk($id);
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
		if(Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest)
		{
			echo CActiveForm::validate($model, $_POST);
			Yii::app()->end();
		}
	}
}
