<?php



namespace app\modules\mch\controllers;

use app\controllers\Controller;

class ErrorController extends Controller
{
    public function actionPermissionError()
    {
        return $this->render('permission-error');
    }
}
