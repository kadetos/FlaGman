<?php
/**
 * Вьюшка просмотра деталей операции
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name .' :: Админцентр - Платежные операции';
$this->breadcrumbs=array(
	'Админцентр' => array('/admin/index'),
	'Операции'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Управление операциями','url'=>array('admin')),
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Операция #<?php echo $model->id; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type' => array('condensed', 'bordered'),
	'htmlOptions' => array('style'=>'text-align: left'),
	'attributes'=>array(
		'id',
		'nickname',
		array(
			'name' => 'steamid',
			'label' => !$model->tariff ? 'ID бана' : NULL,
		),
		'ip',
		//'server1.hostname',
		'sum',
		array(
			'name' => 'tariff',
			'value' => !$model->tariff ? "Разбан" : ($model->tariff1 ? $model->tariff1->name : "-")
		),

		array(
			'name' => 'status',
			'value' => Billing::getStatusName($model->status)
		),
		array(
			'name' => 'create',
			'type' => 'datetime',
			'value' => $model->create
		),
		array(
			'name' => 'update',
			'type' => 'datetime',
			'value' => $model->update
		),
		array(
			'name' => 'desc',
			'type' => 'raw',
			'value' => '<pre>' . CVarDumper::dumpAsString(unserialize($model->desc)) . '</pre>'
		),
	),
)); ?>
