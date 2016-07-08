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

$this->pageTitle = Yii::app()->name .' :: Админцентр - Робокасса';
$this->breadcrumbs=array(
	'Админцентр' => array('/admin/index'),
	'Тарифы'=>array('admin'),
	'Робокасса',
);

$this->menu=array(
	array('label'=>'Управление тарифами','url'=>array('admin')),
);
$this->renderPartial('//admin/mainmenu', array('active' =>'site', 'activebtn' => 'tariffs'));
?>

<h2>Настройки Робокассы</h2>

<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'robo-form',
	'enableAjaxValidation'=>false,
));
?>
	<?php echo CHtml::textField('robokassa_login', Yii::app()->params['robokassa_login'], array('placeholder' => 'Логин')); ?><br>
	<?php echo CHtml::textField('robokassa_pass1', Yii::app()->params['robokassa_pass1'], array('placeholder' => 'Пароль 1')); ?><br>
	<?php echo CHtml::textField('robokassa_pass2', Yii::app()->params['robokassa_pass2'], array('placeholder' => 'Пароль 2')); ?><br>
	<label class="checkbox"><?php echo CHtml::checkBox('robokassa_testing', (bool)Yii::app()->params['robokassa_testing']); ?> Тестовый режим</label>
	<?php if(!$installed): ?>
	<label class="checkbox"><?php echo CHtml::checkBox('robokassa_license'); ?> Я петух и согласен с условиями <?php echo CHtml::link('лицензионного соглашения', array('/billing/license'))?></label>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' =>'primary',
			'label' => 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>