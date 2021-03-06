<?php
/**
 *选校
 * Created by PhpStorm.
 * by yoyo
 */
namespace app\modules\cn\controllers;

use yii;
use app\libs\Method;
use app\libs\ThinkUController;
use app\modules\cn\models\SchoolTest;
use app\modules\cn\models\UserBackground;
use app\modules\cn\models\ProbabilityTest;

class SchoolChoiceController extends ThinkUController
{
    public $enableCsrfValidation = false;
    public $layout = 'cn';

    public function actionBackground()
    {
        $this->title = '出国留学_美国留学_英国留学_澳洲留学_留学申请_申友留学';
        $this->keywords = '留学评估，留学测评，录取几率，背景测评，选校测评，留学中介，美国留学中介，留学中介顾问，留学中介机构，英国留学中介，放心留学中介，值得信赖的留学中介，好的留学中介';
        $this->description = '申友网专业留学测评系统，为准备出国留学的学生提供免费的留学竞争力分析报告，根据客户填写的个人背景信息，快速进行背景测评、选校测评和录取几率测评等';
        return $this->render('background');
    }

    public function actionPercentages()
    {
        if (!$_POST) {
            $data = ProbabilityTest::find()->asArray()->orderBy("id desc")->limit(15)->all();
            $this->title = '出国留学_美国留学_英国留学_澳洲留学_留学申请_申友留学';
            $this->keywords = '留学评估，留学测评，录取几率，背景测评，选校测评，留学中介，美国留学中介，留学中介顾问，留学中介机构，英国留学中介，放心留学中介，值得信赖的留学中介，好的留学中介';
            $this->description = '申友网专业留学测评系统，为准备出国留学的学生提供免费的留学竞争力分析报告，根据客户填写的个人背景信息，快速进行背景测评、选校测评和录取几率测评等';
            return $this->render('percentages', ['data' => $data]);
        }
    }

    public function actionChoice()
    {
        if (!$_POST) {
            $data = SchoolTest::find()->asArray()->orderBy("id desc")->limit(15)->all();
            $this->title = '出国留学_美国留学_英国留学_澳洲留学_留学申请_申友留学';
            $this->keywords = '留学评估，留学测评，录取几率，背景测评，选校测评，留学中介，美国留学中介，留学中介顾问，留学中介机构，英国留学中介，放心留学中介，值得信赖的留学中介，好的留学中介';
            $this->description = '申友网专业留学测评系统，为准备出国留学的学生提供免费的留学竞争力分析报告，根据客户填写的个人背景信息，快速进行背景测评、选校测评和录取几率测评等';

            return $this->render('choice', ['data' => $data]);
        }
    }

    public function actionProbabilityResult()
    {
        $id = Yii::$app->request->get('id', '');
        if ($id == false) {
            die('<script>alert("访问出错！");history.go(-1);</script>');
        }
        $res = ProbabilityTest::find()->asArray()->where("id={$id}")->one();
        $h['gpa'] = $res['gpa'];
        $h['gmat'] = $res['gmat'];
        $h['toefl'] = $res['toefl'];
        $h['schoolGrade'] = $res['schoolGrade'];
        $h['attendSchool'] = $res['attendSchool'];
        $h['most'] = 6;
        $score = Method::score($h);
        if ($res['schoolGrade'] == 1) {
            $schoolGrade = "清北复交浙大";
        } elseif ($res['schoolGrade'] == 2) {
            $schoolGrade = "985学校";
        } elseif ($res['schoolGrade'] == 3) {
            $schoolGrade = "211学校";
        } elseif ($res['schoolGrade'] == 4) {
            $schoolGrade = "非211本科";
        } else {
            $schoolGrade = "专科";
        }
        $data = ['res' => $score, 'score' => $res['score'], 'percent' => $res['percent'], 'school' => $res['school'], 'major' => $res['major'], 'schoolGrade' => $schoolGrade, 'userName' => $res['userName'], 'data' => $res];
        $this->title = '出国留学_美国留学_英国留学_澳洲留学_留学申请_申友留学';
        $this->keywords = '留学评估，留学测评，录取几率，背景测评，选校测评，留学中介，美国留学中介，留学中介顾问，留学中介机构，英国留学中介，放心留学中介，值得信赖的留学中介，好的留学中介';
        $this->description = '申友网专业留学测评系统，为准备出国留学的学生提供免费的留学竞争力分析报告，根据客户填写的个人背景信息，快速进行背景测评、选校测评和录取几率测评等';

        return $this->render('probabilityResult', ['code' => 1, 'data' => $data]);
    }

    /**
     * 选校结果
     * by yoyo
     */
    public function actionSchoolResult()
    {
        $id = Yii::$app->request->get('id', '');
        if ($id == false) {
            die('<script>alert("访问出错！");history.go(-1);</script>');
        }
        $res = SchoolTest::find()->asArray()->where("id={$id}")->one();
        $result = unserialize($res['result']);
        $data = Method::post("http://schools.viplgw.cn/cn/api/school-choice", ['result' => $result]);
        $school = json_decode($data, true);
        if ($res['schoolGrade'] == 1) {
            $schoolGrade = "清北复交浙大";
        } elseif ($res['schoolGrade'] == 2) {
            $schoolGrade = "985学校";
        } elseif ($res['schoolGrade'] == 3) {
            $schoolGrade = "211学校";
        } elseif ($res['schoolGrade'] == 4) {
            $schoolGrade = "非211本科";
        } else {
            $schoolGrade = "专科";
        }
        $score = Method::score($res);
        $this->title = '出国留学_美国留学_英国留学_澳洲留学_留学申请_申友留学';
        $this->keywords = '留学评估，留学测评，录取几率，背景测评，选校测评，留学中介，美国留学中介，留学中介顾问，留学中介机构，英国留学中介，放心留学中介，值得信赖的留学中介，好的留学中介';
        $this->description = '申友网专业留学测评系统，为准备出国留学的学生提供免费的留学竞争力分析报告，根据客户填写的个人背景信息，快速进行背景测评、选校测评和录取几率测评等';

        return $this->render('schoolResult', ['code' => 1, 'res' => $res, 'data' => $school, 'score' => $score, 'schoolGrade' => $schoolGrade, 'applyMajor' => $res['majorName'], 'testId' => $res['id']]);
    }


}