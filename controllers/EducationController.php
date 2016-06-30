<?php
namespace frontend\controllers;

use common\models\UsersEducations;
use common\models\School;
use common\models\Degree;
use common\models\Updates;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
class EducationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        return $this->render('view');
    }

    public function actionAddSchool() {
        $val = Yii::$app->request->post('data');
        $usrschool = new School;
        $usrschool->name = $val;
        $usrschool->time = date("Y-m-d h:i:sa");
        
        if($usrschool->save())
        { return $usrschool->id; }
        return 0;
    }
    public function actionAddDegree() {
        $val = Yii::$app->request->post('data');
        $usrdegree = new Degree;
            $usrdegree->name = $val;
            
        
        if($usrdegree->save())
        { return $usrdegree->id; }
        return 0;
    }
    
    public function actionAddEducation() {
    $model = new UsersEducations();
    $model->scenario = 'schoolfun';   
    $model->load(Yii::$app->request->post());
    
    if (Yii::$app->request->isPost and ($model->validate())) {
        //echo '<pre>';        print_r($model); exit;
        return UsersEducations::addEducation($model);
        } else     {           echo '<pre>'; print_r($model->getErrors()); exit;  }
}

public function actionDeleteEducation() {
    //$model = new models\UsersEducations();
    //$model->load(Yii::$app->request->post());
    if (Yii::$app->request->isPost) {
        if(Yii::$app->request->post('schoolNum') != ''){
            $model = UsersEducations::find()->where(['id'=>Yii::$app->request->post('schoolNum')])->andWhere(['users_id'=>  \Yii::$app->user->id])->one();
//echo '<pre>'.Yii::$app->request->post('schoolNum');print_r($model); exit;
            if(!is_null($model)){ 
                $model->delete(); 
                Updates::addNewUpdate(4, 'users_educations', TRUE);
            }
            return 1;
        } else {            return 9999; }
    } else { return 0; }
}



public function actionGetUserEducation() {
    $retarray = '';
    $education = UsersEducations::findUserschool(\Yii::$app->user->id)->getModels();
    foreach ($education as $value) {
        //echo '<pre>';        print_r($value->theme[0]->name); exit;
        $retarray .= '
        <script>
        $(function() {
            editschool(\'edit-school\',\''.$value->id.'\',\''.$value->schoolDetail->name.'\',\''.$value->degreeDetail->name.'\',\''.$value->from.'\',\''.$value->to.'\');
        });
    </script>
        <div class="profile-p relative">
        <div class="profile-icon-space"><img src="/themes/sakuti/images/east-chaina.png"/></div>
        <div class="profile-icon-detail">
            <div class="relative profile-detail-heading">
                <div class="profile-edit-icon"><a href="#" class="flaticon-pencil30 edit-icon-color "></a></div>
                '.$value->schoolDetail->name.'
            </div>
            <div>
                <ul class="profile-experience-detail">
                    <li>'.$value->from.' to '.$value->to.'</li>
                    <li>'.$value->degreeDetail->name.'</li>

                </ul>
            </div>

        </div>
    </div>';
   
          
    }
    return $retarray;
}
    
    
    
    
    
}
