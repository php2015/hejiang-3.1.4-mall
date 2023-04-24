<?php


namespace app\controllers;


use app\models\ContactForm;

class ContactController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionCallback()
    {
        if (\Yii::$app->request->isPost) {
            $form = new ContactForm();
            $form->attributes = \Yii::$app->request->get();
            $form->attributes = \Yii::$app->request->post();
            return $this->asJson($form->search());
        }
    }
}
