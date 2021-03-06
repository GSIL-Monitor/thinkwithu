<?php
/**
 *课程
 * Created by PhpStorm.
 * User: obelisk
 * Date: 15-11-25
 * Time: 上午10:51
 */
namespace app\modules\cn\controllers;
use yii;

use app\libs\ThinkUController;
use app\libs\P;

class SearchController extends ThinkUController {
    public $enableCsrfValidation = false;
    public $layout = 'cn';
    public function actionIndex(){
        $keyword  = Yii::$app->request->get('keyword', '');
        $keyword  =addslashes($keyword);
        $keyword  =strip_tags($keyword);
        $p        = Yii::$app->request->get('p', '1');
        $pagesize = 15;
        $offset   = $pagesize * ($p - 1);
        $data     = Yii::$app->db->createCommand("select DISTINCT c.id,c.name,catId from {{%content}} c left join {{%content_extend}} ce on ce.contentId=c.id left join {{%extend_data}} ed on ed.extendId=ce.id  where c.name like '%$keyword%' and c.catId in (102,104,117,118,121,125,166,178,205,225) order by id desc limit $offset,$pagesize")->queryAll();
        $count    = count(Yii::$app->db->createCommand("select DISTINCT c.id,c.name,catId from {{%content}} c left join {{%content_extend}} ce on ce.contentId=c.id left join {{%extend_data}} ed on ed.extendId=ce.id  where c.name like '%$keyword%' and c.catId in (102,104,117,118,121,125,166,178,205,225)")->queryAll());
        $myPage=new P('/search.html?keyword='.$keyword.'&p', $count,$p, $pagesize);
        $str= $myPage->GetPager();
        return $this->render('index',['data'=>$data,'str'=>$str]);
    }
}