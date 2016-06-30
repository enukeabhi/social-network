<?php
namespace frontend\controllers;

use common\models\UsersSkills;
use common\models\Skills;
use common\models\Updates;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
class SkillsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        return $this->render('view');
    }

    public function actionAddSkills() {
    $model = new UsersSkills();
    $model->load(Yii::$app->request->post());
    if (Yii::$app->request->isPost) {
        if (!is_null($model->addNewSkill)) {
            //echo '<pre>';        print_r($model->cultural_theme_id); exit;
            return $model->addNewSkills();
        } else {            return 9999; }
        
    } else     {   return 0; }
}

public function actionGetUserSkills() {
     $retarray = '';
    $usrSkills = UsersSkills::findSkills(\Yii::$app->user->id)->getModels();
    foreach ($usrSkills as $value) {
        //echo '<pre>';        print_r($value->theme[0]->name); exit;
        $retarray .= '<li id="cul-theme-'.$value->skills->id.'">'.$value->skills->name.'<a href="#" onclick="removeTheme('.$value->skills->id.')">
           <img src="/themes/sakuti/images/close-icon.png" class="mar-lft12"></a></li>';
    }
    return $retarray;
}

public function actionGetSkillsOptions() {
    $retarray = '';
    $usrSkill = UsersSkills::findAll(['users_id'=>  Yii::$app->user->id]);
    $totSkill = count($usrSkill);
    $skillArr = array();
    for($i=0;$i<$totSkill;$i++){
        $skillArr[] = $usrSkill[$i]->skills_id;
    }
    //echo '<pre>'; print_r($skillArr);
    $usrmodel = Skills::find()->where(['not in','id',$skillArr])->all();
    //$skillArray = array();
    for($i=0;$i<count($usrmodel);$i++){
        //echo $usrmodel[$i]->id;
        $retarray .= "<option value=".$usrmodel[$i]->id.">".$usrmodel[$i]->name."</option>";
        //
    }
    return $retarray;
}

public function actionRemoveSkill() {
    if (Yii::$app->request->isPost) {
        $id = Yii::$app->request->post('skillId');
        $usrid = Yii::$app->user->id;
        $model = UsersSkills::find()->where(['skills_id'=>$id])->andWhere(['users_id'=>$usrid])->one();
                
        if($model->delete()){
            Updates::addNewUpdate(6, 'users_skills', TRUE);  
            return 1;
        } else     {       return 9999; }
    } else     {   return 0; }
}
}
