<?php
/**
 * Вьюшка редактирования тарифа
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name .' :: Админцентр - Редактировать тариф' . $model->name;
$this->breadcrumbs=array(
	'Админцентр' => array('/admin/index'),
	'Тарифы'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Детали тарифа','url'=>array('view','id'=>$model->id)),
	array('label'=>'Добавить тариф','url'=>array('create')),
	array('label'=>'Управление тарифами','url'=>array('admin')),
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Редактировать тариф <?php echo $model->name; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>