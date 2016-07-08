<?php
/**
 * Вьюшка магазина (Второй шаг)
 *
 * @author Craft-Soft Team
 * @version 6.1 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @package AmxBans
 * @link http://craft-soft.ru/
*/

$this->pageTitle = Yii::app()->name . ' :: Магазин';
$this->breadcrumbs = array(
	'Магазин',
);
?>

<h2>Магазин</h2>

<form action="<?php echo $robo['URL'] ?>" method="POST">

<div class="alert alert-info">
	Итого к оплате: <b><?php echo $model->sum; ?></b> руб. без учета комиссии системы.
</div>

<?php foreach($robo['Hidden'] AS $k => $v): ?>
	<?php echo CHtml::hiddenField($k, $v); ?>
<?php endforeach; ?>

<?php echo CHtml::submitButton('Оплатить', array('class' => 'btn btn-large btn-primary')); ?>

</form>