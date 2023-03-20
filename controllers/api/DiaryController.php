<?
namespace app\controllers\api;

use app\models\Diary;
use yii\rest\ActiveController;

class DiaryController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
        ];

        return $behaviors;
    }
    public $modelClass = Diary::class;
    public function actionJwt()
    {
        $user = \Yii::$app->user->identity;
        var_dump($user->email);
    }
}
?>