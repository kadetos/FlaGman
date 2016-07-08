<?php
/**
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
 */

/**
 * Модель для таблицы "{{billing}}".
 *
 * @property integer $id ID записи
 * @property integer $tariff ID тарифа
 * @property integer $sum Стоимость
 * @property integer $days Дней
 * @property string $status Статус
 * @property integer $create Дата создания
 * @property integer $update Дата обновления
 * @property string $desc Описане
 * @property integer $server Сервер
 * @property integer $auth Тип админки (Стим, IP, ник/пароль)
 * @property string $steamid Данные админа
 * @property string $password Пароль (если по нику)
 * @property string $nickname Ник (Отображается на странице с админами)
 * @property string $ip IP
 * @property string $email Почта
 *
 * @property Tariff[] $tariff1 Данные тарифа
 */
class Billing extends CActiveRecord
{

	const STATUS_CREATED = 'created';
	const STATUS_PAID = 'paid';
	const STATUS_CANCEL = 'cancel';
	const STATUS_RETURN = 'return';
	const STATUS_STOP = 'stop';

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{billing}}';
	}

	public function rules()
	{
		return array(
			array('server, tariff, auth, steamid, nickname, email, days', 'required'),
			array('auth, steamid, nickname', 'safe'),
			array('tariff, server, days', 'numerical', 'integerOnly'=>true),
			array('steamid, nickname', 'length', 'max'=>32),
			array('password', 'filter', 'filter'=>'md5', 'on' => 'buy'),
			array('email', 'email'),
			array('auth', 'in', 'range' => array_keys(Amxadmins::getAuthType())),

			array('id, tariff, sum, status, create, update, desc, steamid, password, nickname, ip, email', 'safe', 'on'=>'search'),
		);
	}

	public function getStatusList() {
		return array(
			self::STATUS_CREATED => 'Создан',
			self::STATUS_PAID => 'Оплачен',
			self::STATUS_CANCEL => 'Отменен',
			self::STATUS_RETURN => 'Возврат',
			self::STATUS_STOP => 'Неожиданная остановка',
		);
	}

	public function getStatusName($key) {
		$list = self::getStatusList();

		if(isset($list[$key]))
			return $list[$key];

		return 'Неизвестный статус';
	}

	public function relations()
	{
		return array(
			'tariff1' => array(
				self::BELONGS_TO,
				'Tariff',
				'tariff',
			),
			'ban' => array(
				self::BELONGS_TO,
				'Bans',
				'steamid',
			),
			'server1' => array(
				self::HAS_ONE,
				'Serverinfo',
				'server',
			),
		);
	}

	public function getPayDesc() {

		return "Оплата счета №{$this->id}";
	}

	protected function beforeValidate() {

		if($this->tariff === '0') {

			return parent::beforeValidate();
		}

		if($this->auth == 'a' && strlen($this->password) < 5) {
			$this->addError('password', 'Пароль не может быть короче 4 символов');
		}

		if(!in_array($this->server, $this->tariff1->servers)) {
			$this->addError('tariff', 'Услуга не доступна на выбранном сервере');
		}

		if(!in_array($this->days, $this->tariff1->dayList)) {
			$this->addError('days', 'Указан некорректный срок');
		}
		
		if($this->auth === 'ce' && !Prefs::validate_value($this->steamid, 'steamid')) {
			$this->addError('steamid', 'Указан некорректный SteamID');
		}

		$admins = Amxadmins::model()->findAllByAttributes(array(
			'steamid' => $this->steamid,
			'flags' => $this->auth,
		));

		foreach($admins AS $admin) {
			if($admin->expired && $admin->expired < time()) {
				continue;
			}

			if(AdminsServers::model()->countByAttributes(array(
				'admin_id' => $admin->id,
				'server_id' => $this->server,
			))) {
				$this->addError('steamid', 'Введенные данные уже используются');
			}
		}

		return parent::beforeValidate();
	}

	protected function beforeSave() {

		if($this->isNewRecord) {

			$this->create = time();
			$this->ip = $_SERVER['REMOTE_ADDR'];

			if($this->tariff === '0') {

				$this->sum = self::getUnbanSum($this->days);
			}
			else {
				$this->sum = ceil($this->tariff1->cost * $this->days);
			}

			$this->status = self::STATUS_CREATED;

			$this->desc = '';
		}

		$this->update = time();

		return parent::beforeSave();
	}

	public function getUnbanSum($days) {

		$cfg = Config::getCfg();

		if(!$days) {
			return $cfg->permanently;
		}
		elseif($days <= 1) {
			return $cfg->day;
		}
		elseif($days <= 3) {
			return $cfg->threeday;
		}
		elseif($days <= 7) {
			return $cfg->weekly;
		}
		elseif($days <= 30) {
			return $cfg->mounth;
		}
		else {
			return $cfg->permanently;
		}
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tariff' => 'Тариф',
			'sum' => 'Сумма',
			'status' => 'Статус',
			'create' => 'Создан',
			'update' => 'Обновлен',
			'desc' => 'Описание',
			'server' => 'Сервер',
			'auth' => 'Способ авторизации',
			'steamid' => 'SteamID / Ник / IP',
			'password' => 'Пароль',
			'nickname' => 'Ник',
			'ip' => 'IP',
			'email' => 'Email',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('tariff',$this->tariff);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create',$this->create,true);
		$criteria->compare('update',$this->update,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('steamid',$this->steamid,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}