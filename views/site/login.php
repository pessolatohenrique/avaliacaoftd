<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use app\models\PasswordResetRequestForm;
use app\models\User;

$this->title = 'FTD Avaliação | Login';
?>

<div class="login-box">
    <!-- /.login-logo -->
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <div class="login-box-body">
        <h2 class="text-center">Login</h2>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Usuário") ?>

            <?= $form->field($model, 'password')->passwordInput()->label("Senha") ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label("Lembrar Senha") ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('Esqueci minha senha',['site/request-password-reset'],
                    [
                        'class' => 'btn btn-info',
                        'data-toggle' => 'modal',
                        'data-target' => "#w0"
                    ])?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

<?php
Modal::begin([
    'header' => '<h4>Esqueci minha senha</h4>',
]);
    $model_password = new PasswordResetRequestForm();
    echo $this->render('requestPasswordResetToken', [
        'model' => $model_password,
    ]);

Modal::end();
?>