<?php
/**
 * toefl单页
 * Created by PhpStorm.
 * User: Fawn
 * Date: 15-11-23
 * Time: 上午10:51
 */
namespace app\modules\cn\controllers;
use yii;
use app\modules\cn\models\CategoryExtend;
use app\libs\ThinkUController;

class IeltssheetController extends ThinkUController {
    public $enableCsrfValidation = false;
    public $layout = 'cn';
    /**
     * 雅思单页
     * by obelisk
     */
    public function actionIndex(){
//        $extendData = CategoryExtend::find()->where("catId=247 AND belong='content'")->orderBy('id ASC')->all();
        $data = file_get_contents('http://ielts.viplgw.cn/cn/api/ielts');
        $data=json_decode($data,true);
//        echo '<pre>';var_dump($data);die;
        return $this->render('index',['data' => $data]);
//        return $this->renderPartial('index');
    }
}