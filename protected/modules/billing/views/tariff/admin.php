<?php
/**
 * Вьюшка управления тарифами
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name . ' :: Админцентр - Тарифы';
$this->breadcrumbs = array(
	'Админцентр' => array('/admin/index'),
	'Тарифы'
);

$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));

$this->menu=array(
	array('label'=>'Добавить тариф', 'url'=>array('create')),
	array('label'=>'Операции', 'url'=>array('/billing/admin')),
	array('label'=>'Настройки Робокассы', 'url'=>array('/billing/tariff/settings')),
);
?>

<h2>Управление тарифами</h2>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tariff-grid',
	'type' => 'bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'cost',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<hr />

<h2>Настройки платежной системы</h2>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'config-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($config); ?>
	<?php echo $form->dropDownListRow($config,'status', Config::statuses(), array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($config,'day',array('class'=>'span5', 'append' => 'руб.')); ?>
	<?php echo $form->textFieldRow($config,'threeday',array('class'=>'span5', 'append' => 'руб.')); ?>
	<?php echo $form->textFieldRow($config,'weekly',array('class'=>'span5', 'append' => 'руб.')); ?>
	<?php echo $form->textFieldRow($config,'mounth',array('class'=>'span5', 'append' => 'руб.')); ?>
	<?php echo $form->textFieldRow($config,'permanently',array('class'=>'span5', 'append' => 'руб.')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>