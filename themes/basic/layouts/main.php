<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\UserAsset;

UserAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="<?=Yii::$app->user->isGuest?"full-page":""?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?=Url::base()?>/favicon.ico" type="image/gif">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?=$this->render('navbar_widget') ?>
<div class="wrap">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<?=$this->render('footer')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>