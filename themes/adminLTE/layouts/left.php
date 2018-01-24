<?php
use yii\helpers\Url;
$foto_perfil = "http://www.amigoviajante.com.br/img/usuario-sem-foto.png";
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?=$foto_perfil?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Administrador', 'options' => ['class' => 'header']],
                    ['label' => 'Item 01', 'icon' => 'users', 'url' => ['#']],
                    ['label' => 'Item 02', 'icon' => 'users', 'url' => ['#']]

                ],
            ]
        ) ?>

    </section>

</aside>
