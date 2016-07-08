<?php
/**
 * Вьюшка покупки разбана
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
 *
 */

$this->pageTitle = Yii::app()->name . ' :: Платный разбан';
$this->breadcrumbs = array(
	'Платный разбан',
);
?>

<h2>Платный разбан</h2>

<?php echo CHtml::errorSummary($model); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'buy-form',
	//'type'=>'horizontal',
	//'enableAjaxValidation'=>TRUE,
));?>

<table class="table table-bordered table-striped table-condensed">
	<tr>
		<td width="40%">Ник</td>
		<td><?php echo CHtml::encode($ban->player_nick); ?></td>
	</tr>
	<tr>
		<td>Срок бана</td>
		<td><?php echo $ban->ban_length ? Prefs::date2word($ban->ban_length) : 'Навсегда'; ?></td>
	</tr>
	<tr>
		<td>Стоимость разбана</td>
		<td><?php echo Billing::getUnbanSum($days); ?> руб.</td>
	</tr>
</table>

<?php echo CHtml::label('Email', 'email'); ?>
<?php echo CHtml::emailField('email'); ?><br>

<?php echo CHtml::submitButton('Купить', array('class' => 'btn primary')); ?>

<?php $this->endWidget(); ?>
