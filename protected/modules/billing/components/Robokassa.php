<?php

class Robokassa 
{
	private $login = null;
	private $pass1 = null;
	private $pass2 = null;
	private $link = 'https://merchant.roboxchange.com/Index.aspx';
	private $testing = false;
	private $success = false;

	function __construct() 
	{
		$this->login = $this->params['robokassa_login'];
		$this->pass1 = Yii::app(  )->params['robokassa_pass1'];
		$this->pass2 = Yii::app(  )->params['robokassa_pass2'];

		if (Yii::app(  )->params['robokassa_testing']) 
		{
			$this->link = 'http://test.robokassa.ru/Index.aspx';
			
			$this->testing = true;
		}	
	}

	function isSuccess() 
	{
		return $this->success;
	}

	function getIdField() 
	{
		return 'InvId';
	}

	function getForm($model) 
	{	
		$Sign = md5( $this->login . ':' . $model->sum . ':' . $model->id . ':' . $this->pass1 );
		$data['SUM'] = $model->sum;
		$data['URL'] = $this->link;
		$data['Hidden']['MrchLogin'] = $this->login;
		$data['Hidden']['OutSum'] = $model->sum;
		$data['Hidden']['InvId'] = $model->id;
		$data['Hidden']['Desc'] = $model->payDesc;
		$data['Hidden']['SignatureValue'] = $Sign;
		
		return $data;
	}

	function resultUrl($model) 
	{
		if ((double)$_POST['OutSum'] != (double)$model->sum) 
			return 'Invalid OutSum';
		
		$Sign = md5($_POST['OutSum'] . ':' . $_POST['InvId'] . ':' . $this->pass2 );

		if ($Sign != strtolower( $_POST['SignatureValue'] )) 
			return 'Invalid Sign';
		
		$this->success = true;

		return 'OK' . $_POST['InvId'];
	}
}