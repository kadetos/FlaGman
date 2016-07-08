<?php
/**
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
 */

/**
 * Модель для таблицы "{{config}}".
 *
 * @property string $status Статус системы
 * @property integer $day Стоимость разбана сроком на день
 * @property integer $threeday Стоимость разбана сроком от дня до трех
 * @property integer $weekly Стоимость разбана сроком от трех дней до недели
 * @property integer $mounth Стоимость разбана сроком от недели до месяца
 * @property integer $permanently Стоимость разбана сроком навсегда
 */
class Config extends CActiveRecord
{
	const STATUS_ENABLED	= 'ENABLED';
	const STATUS_ADMIN		= 'ADMIN';
	const STATUS_UNBAN		= 'UNBAN';
	const STATUS_DISABLED	= 'DISABLED';

	public function tableName()
	{
		return '{{config}}';
	}

	public function rules()
	{
		return array(
			array('day, threeday, weekly, mounth, permanently', 'required'),
			array('day, threeday, weekly, mounth, permanently', 'numerical', 'integerOnly'=>true),
			array('status', 'in', 'range' => array_keys(self::statuses())),

			array('status, day, threeday, weekly, mounth, permanently', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'status' => 'Статус системы',
			'day' => 'До суток',
			'threeday' => 'До 3 дней',
			'weekly' => 'До недели',
			'mounth' => 'До месяца',
			'permanently' => 'Больше месяца',
		);
	}

	public static function getCfg() {

		$cache = Yii::app()->cache->get('billing_cfg');

		if($cache === FALSE) {

			$cache = self::model()->find();
			Yii::app()->cache->set('billing_cfg', $cache, 21600);
		}

		return $cache;
	}

	public function getStatus($admin = TRUE) {

		$cfg = self::model()->find();

		if(
			$cfg->status === self::STATUS_ENABLED
				||
			($cfg->status === self::STATUS_ADMIN && $admin)
				||
			($cfg->status === self::STATUS_UNBAN && !$admin)
		) {
			return TRUE;
		}

		return FALSE;
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('status',$this->status,true);
		$criteria->compare('day',$this->day);
		$criteria->compare('threeday',$this->threeday);
		$criteria->compare('weekly',$this->weekly);
		$criteria->compare('mounth',$this->mounth);
		$criteria->compare('permanently',$this->permanently);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function statuses()
	{
		return array(
			self::STATUS_ENABLED => 'Система включена',
			self::STATUS_ADMIN => 'Включена только продажа админки',
			self::STATUS_UNBAN => 'Включен только разбан',
			self::STATUS_DISABLED => 'Система выключена полностью'
		);
	}

	public function afterSave() {
		
		if(!$this->isNewRecord) {
			Syslog::add(Logs::LOG_EDITED, 'Изменен конфиг платежной системы');
		}

		Yii::app()->cache->delete('billing_cfg');

		return parent::afterSave();
	}
}
