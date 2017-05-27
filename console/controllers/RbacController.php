<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;
        
        // Создать роль админа
        $admin = $auth->createRole('admin');
        
        // Записать роль в базу
        $auth->add($admin);
        
        // Добавить разрешение добавлять ингридиенты
        $create_ingr = $auth->createPermission('create_ingr');
        
        $create_ingr->description = 'Добавлять ингидиент';
        
        // Запишем эти разрешения в БД
        $auth->add($create_ingr);
        
        //Разрешаем админу добавлять ингридиенты
        $auth->addChild($admin,$create_ingr);

        
        $auth->assign($admin, 1); 
        
        // Назначаем роль editor пользователю с ID 2
        $auth->assign($editor, 2);
    }
}

