<?php
/**
 * Форма добавления/редактирования тарифов
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 * 
 */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tariff-form',
	'enableAjaxValidation'=>false,
));
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textAreaRow($model,'desc',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'cost',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'flags',array('class'=>'span5','maxlength'=>22)); ?>

	<?php echo $form->checkBoxListRow($model,'servers',Serverinfo::getAllServers(FALSE, TRUE),array('class'=>false,'maxlength'=>50)); ?>
	
	<?php echo $form->textFieldRow($model,'days',array('class'=>FALSE,'maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
