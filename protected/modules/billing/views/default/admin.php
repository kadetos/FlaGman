<?php
/**
 * Вьюшка просмотра платных операций
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
	'Тарифы' => array('/tariff/admin'),
	'Платежные операции',
);

$this->menu=array(
	array(
		'label'=>'Тарифы',
		'url'=>array('tariff/admin')
	)
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Операции</h2>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'billing-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name' => 'tariff',
			'value' => '!$data->tariff ? "Разбан" : ($data->tariff1 ? $data->tariff1->name : "-")'
		),
		'sum',

		array(
			'name' => 'status',
			'value' => 'Billing::getStatusName($data->status)'
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{view}'
		),
	),
)); ?>
