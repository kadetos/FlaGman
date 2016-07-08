<?php
/**
 * Вьюшка магазина (Шаг получения ответа от робокассы)
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

<?php if($success): ?>
<div class="alert alert-success">
<h3>Оплата прошла успешно</h3>
<?php else: ?>
<div class="alert alert-error">
<h3>При оплате произошла ошибка</h3>
<?php endif; ?>
</div>
<br>