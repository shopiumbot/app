<?php
use panix\engine\Html;
?>
<div class="jumbotron">
    <div class="col-sm-8 mx-auto">
        <h1>Hi !</h1>

    </div>
</div>
<table class="table table-striped table-bordered">
    <tr>
        <th class="text-center"></th>
        <th class="text-center">Basic</th>
        <th class="text-center">Standard</th>
        <th class="text-center">Premium</th>
    </tr>
    <tr>
        <td class="text-center"></td>
        <td class="text-center">
            <div class="font-weight-bold">300 UAH</div>
            <span class="text-muted">мес.</span>
        </td>
        <td class="text-center">
            <div class="font-weight-bold">700 UAH</div>
            <span class="text-muted">мес.</span>
        </td>
        <td class="text-center">
            <div class="font-weight-bold">2 500 UAH</div>
            <span class="text-muted">мес.</span>
        </td>
    </tr>
    <tr>
        <td class="text-right">Количество товаров в каталоге</td>
        <td class="text-center">200</td>
        <td class="text-center">5000</td>
        <td class="text-center">&infin;</td>
    </tr>
    <tr>
        <td class="text-right">Фото у товаров</td>
        <td class="text-center">1</td>
        <td class="text-center">3</td>
        <td class="text-center">&infin;</td>
    </tr>
    <tr>
        <td class="text-right">Поддержка</td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
    </tr>
    <tr>
        <td class="text-right">Скидки на группы и бренды товаров</td>
        <td class="text-center"><i class="icon-delete text-danger"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
    </tr>
    <tr>
        <td class="text-right">Отключение подписи</td>
        <td class="text-center"><i class="icon-delete text-danger"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
    </tr>
    <tr>
        <td class="text-right">Доступ к API</td>
        <td class="text-center"><i class="icon-delete text-danger"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
    </tr>
    <tr>
        <td class="text-right">Прием платежей</td>
        <td class="text-center"><i class="icon-delete text-danger"></i></td>
        <td class="text-center"><i class="icon-delete text-danger"></i></td>
        <td class="text-center"><i class="icon-check text-success"></i></td>
    </tr>


    <tr>
        <td class="text-right"></td>
        <td class="text-center"><?= Html::a('Регистрация',['/'],['class'=>'btn btn-outline-success']); ?></td>
        <td class="text-center"><?= Html::a('Регистрация',['/'],['class'=>'btn btn-outline-success']); ?></td>
        <td class="text-center"><?= Html::a('Регистрация',['/'],['class'=>'btn btn-outline-success']); ?></td>
    </tr>
</table>

