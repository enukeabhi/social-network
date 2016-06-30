<?php
namespace frontend\controllers;
use common\models\UpdateLikes;
use common\models\UpdateComments;
use common\models\ImagesComments;
use common\models\ImagesLikes;
use Yii;

class UpdateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionAddComment()
    {
        //return 'saved';
        if(Yii::$app->request->isPost){
            //echo '<pre>';            print_r(Yii::$app->request->post());            exit();
            $updateId = Yii::$app->request->post('updateId');
            $comment = Yii::$app->request->post('comment');
            $isForeignKey = Yii::$app->request->post('isForeignKey');
            $type = Yii::$app->request->post('type');
            if(empty($updateId)){
                return 'update Id is EMPTY';
            } else if(empty ($comment)){
                return 'Comment is EMPTY';
            } else {
                
                if($isForeignKey){
                    return ImagesComments::addImagesCommnets($updateId, $comment, $type);
                } else{
                    return UpdateComments::addUpdateComments($updateId, $comment);
                }
            }
        }
        return 0;
    }
    
    public function actionAddLike()
    {
        if(Yii::$app->request->isPost){
            $updateId = Yii::$app->request->post('updateId');
            $isForeignKey = Yii::$app->request->post('isForeignKey');
            $type = Yii::$app->request->post('type');
            if(empty($updateId)){
                return 'update Id is EMPTY';
            } else {
                if($isForeignKey){
                    return ImagesLikes::addImagesLikes($updateId, $type);
                } else{
                    return UpdateLikes::addUpdateLikes($updateId);
                }    
            }
        }
        return 0;
    }

    public function actionRemoveLike()
    {
        if(Yii::$app->request->isPost){
            $updateId = Yii::$app->request->post('updateId');
            $isForeignKey = Yii::$app->request->post('isForeignKey');
            $type = Yii::$app->request->post('type');
            if(empty($updateId)){
                return 'update Id is EMPTY';
            } else {
                if($isForeignKey){
                    return ImagesLikes::removeImagesLikes($updateId, $type);
                } else{
                    return UpdateLikes::removeUpdateLikes($updateId);
                }    
            }
        }
        return 0;
    }

}
