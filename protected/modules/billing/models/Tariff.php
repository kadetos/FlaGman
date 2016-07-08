<?php
/**
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
 */

/**
 * Модель для таблицы "{{Tariff}}".
 *
 * Доступные поля таблицы '{{Tariff}}':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $cost
 * @property string $flags
 * @property string $servers
 * @property string $days
 */
class Tariff extends CActiveRecord
{
	/**
	 * @var array
	 */
	public $dayList = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tariff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tariff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, cost, flags, servers, days', 'required'),
			array('cost', 'numerical', 'integerOnly'=>FALSE),
			array('name', 'length', 'max'=>100),
			array('desc', 'length', 'max'=>255),
			array('flags', 'length', 'max'=>22),
			array('servers, days', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, cost, flags, servers', 'safe', 'on'=>'search'),
		);
	}

	protected function beforeValidate() {

		if(is_array($this->servers)) {
			$this->servers = implode(',', $this->servers);
		}

		return parent::beforeValidate();
	}

	protected function afterFind() {

		$this->servers = explode(',', $this->servers);
		$this->dayList = array_unique(explode(',', $this->days));

		return parent::afterFind();
	}

	public function afterSave() {
		if($this->isNewRecord)
			Syslog::add(Logs::LOG_ADDED, 'Добавлен новый тариф <strong>' . $this->name . '</strong>');
		else
			Syslog::add(Logs::LOG_EDITED, 'Изменены детали тарифа <strong>' . $this->name . '</strong>');
		return parent::afterSave();
	}
	
	public function afterDelete() {
		Syslog::add(Logs::LOG_DELETED, 'Удален тариф <strong>' . $this->name . '</strong>');
		return parent::afterDelete();
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'desc' => 'Описание',
			'cost' => 'Стоимость',
			'flags' => 'Флаги',
			'servers' => 'Сервера',
			'days' => 'Разрешенные дни'
		);
	}

	public function getList($select = FALSE, $id = NULL) {

		if(!$id) {
			$model = self::model()->findAll(array('order' => '`name` ASC'));
		}
		else {
			$model = self::model()->findAll('FIND_IN_SET(:id, `servers`) > 0 ORDER BY `name` ASC', array(':id' => $id));
		}

		return $select ? CHtml::listData($model, 'id', 'name') : $model;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('flags',$this->flags,true);
		$criteria->compare('servers',$this->servers,true);
		$criteria->order = '`name` ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}