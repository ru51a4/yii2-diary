<?
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class Post extends ActiveRecord
{

    public static function tableName()
    {
        return 'posts';
    }

    public function rules()
    {
        return [
            ['message', 'required'],
        ];
    }

    public function Getuser()
    {
        return $this->hasOne(User::className(), ["id" => "user_id"]);
    }

    public function Getdiary()
    {
        return $this->hasOne(Diary::className(), ["id" => "diary_id"]);
    }
}