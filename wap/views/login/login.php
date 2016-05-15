<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" style="text-align:center;">
    <div class="col-xs-12">
        <div class="row" >

                    <?php $form = ActiveForm::begin() ?>
                    <div class="panel-body" style="margin-left: 10px;margin-right: 10px">
                        <?= $form->field($model, 'username', [
                            'template' => '<div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    {input}
                                </div>{error}',
                            'inputOptions' => ['placeholder' => '请输入用户名', 'autocomplete' => 'off']
                        ])->textInput() ?>
                        <?= $form->field($model, 'password', [
                            'template' => '<div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                                    {input}
                                </div>{error}',
                            'inputOptions' => ['placeholder' => '请输入密码', 'autocomplete' => 'off']
                        ])->passwordInput() ?>
                        <?= $form->field($model, 'verify', [
                        ])->widget(yii\captcha\Captcha::className(), [
                            'template' => '<div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-picture"></span>
                                    </span>
                                    {input}
                                    <span class="input-group-addon" style="margin:0;padding:0">
                                    {image}
                                    </span>
                                </div>',
                            'imageOptions' => [
                                'alt' => '点击换图',
                                'title' => '点击换图',
                                'style' => 'cursor:pointer'
                            ],
                            'captchaAction' => 'login/captcha',
                        ])->label(false) ?>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" style="background-color: #a83434;border-color: #a8343;">登录</button>
                        </div>
                    </div>



                    <?php ActiveForm::end() ?>


        </div>
    </div>
</div>






