<?php
/**
 * Вьюшка добавления тарифа
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name .' :: Админцентр - Добавление тарифа';
$this->breadcrumbs=array(
	'Админцентр' => array('/admin/index'),
	'Тарифы'=>array('admin'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Управление тарифами','url'=>array('admin')),
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Создать тариф</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>