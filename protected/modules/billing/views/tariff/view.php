<?php
/**
 * Вьюшка просмотра деталей тарифа
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name .' :: Админцентр - Тариф ' . $model->name;
$this->breadcrumbs=array(
	'Админцентр' => array('/admin/index'),
	'Тарифы'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Редактировать','url'=>array('update','id'=>$model->id)),
	array('label'=>'Удалить','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Добавить тариф','url'=>array('create')),
	array('label'=>'Управление тарифами','url'=>array('admin')),
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Детали тарифа <?php echo $model->name; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
		'cost',
		'flags',
	),
)); ?>
