<?php
/**
 * Вьюшка магазина
 *
 * @author Craft-Soft Team
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package CS:Bans
 * @link http://craft-soft.ru/
 */

$this->pageTitle = Yii::app()->name . ' :: Магазин';
$this->breadcrumbs = array(
	'Магазин',
);
?>

<h2>Магазин с автопокупкой админки и разбана </h2>

<?php echo CHtml::errorSummary($model); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'buy-form',
));?>

<fieldset class="">
	<legend>Выберите сервер</legend>
	<?php foreach($servers AS $k => $v): ?>
	<label class="radio"><input type="radio" name="server" value="<?php echo $k; ?>"<?php
		echo $server == $k ? ' checked="checked"' : ''; ?>> <?php echo $v; ?></label>
	<?php endforeach; ?>
</fieldset>

<?php if($server): ?>
<script>
	$(function(){
		$("a.tariffInfo").popover();
	});
</script>
<fieldset class="">
	<legend>Выберите услугу</legend>
	<?php if(count($tariffs)): ?>
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th style="width: 250px">Тариф</th>
				<th>Описание</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tariffs AS $v): ?>
			<tr>
				<td style="vertical-align: middle">
					<label class="radio">
						<input 
							type="radio" 
							name="tariff" 
							value="<?php echo $v->id; ?>"
							<?php if($tariff == $v->id) echo ' checked="checked"'?>> 
							<?php echo $v->name; ?> 
						<small>(<?php echo $v->cost; ?> руб.)</small>
					</label>
				</td>
				<td><?php echo nl2br($v->desc)?></trd>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php else: ?>
		<div class="alert alert-error">Нет услуг для выбранного сервера</div>
	<?php endif; ?>
</fieldset>
<?php endif; ?>

<?php if($tariff): ?>
<fieldset class="">
	<legend>Укажите период</legend>
	<label>Кол-во дней: <select name="days">
	<?php foreach(Tariff::model()->findByPk($tariff)->dayList AS $v): ?>
		<option value="<?php echo $v; ?>"<?php echo $days === $v
				? ' selected="selected"' : ''; ?>> <?php echo $v; ?></option>
	<?php endforeach; ?>
	</select></label>
</fieldset>
<?php endif; ?>

<?php if($tariff): ?>
<fieldset class="">
	<legend>Выберите способ входа</legend>
	<?php foreach(Amxadmins::getAuthType() AS $k => $v): ?>
	<label class="radio"><input type="radio" name="auth" value="<?php echo $k; ?>"<?php
		echo $auth === $k ? ' checked="checked"' : ''; ?>> <?php echo $v; ?></label>
	<?php endforeach; ?>
</fieldset>
<?php endif; ?>

<?php if($auth): ?>
<fieldset class="">
	<legend>Укажите данные</legend>
	<?php echo CHtml::textField('nickname', '', array('placeholder' => 'Отображаемое имя')); ?>
	<?php echo CHtml::error($model, 'nickname'); ?><br />

	<?php if($auth == 'a'): ?>
	<?php echo CHtml::textField('steamid', '', array('placeholder' => 'Ник в игре')); ?>
	<?php echo CHtml::error($model, 'steamid'); ?><br />
	<?php echo CHtml::textField('password', '', array('placeholder' => 'Пароль')); ?>
	<?php echo CHtml::error($model, 'password'); ?><br />

	<?php elseif($auth == 'ce'): ?>
	<?php echo CHtml::textField('steamid', '', array('placeholder' => 'SteamID')); ?>
	<?php echo CHtml::error($model, 'steamid'); ?><br />

	<?php elseif($auth == 'de'): ?>
	<?php echo CHtml::textField('steamid', '', array('placeholder' => 'IP')); ?>
	<?php echo CHtml::error($model, 'steamid'); ?><br />
	<?php endif; ?>

	<?php echo CHtml::emailField('email', '', array('placeholder' => 'Email')); ?>
	<?php echo CHtml::error($model, 'email'); ?><br />

	<?php echo CHtml::submitButton('Купить', array('class' => 'btn primary')); ?>
</fieldset>
<?php endif; ?>

<?php $this->endWidget(); ?>
<script>
$(document).ready(function(){
	$('#buy-form input[type=radio]').change(function(){
		$("#loading").show();
		$.get('', $('#buy-form').serialize(), function(data){
			$("#loading").hide();
			$('#content').html(data);
		});
	});
});
</script>