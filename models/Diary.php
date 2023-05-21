<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class Diary extends ActiveRecord
{
    public static function tableName()
    {
        return 'diaries';
    }
    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }
    public function Getuser()
    {
        return $this->hasOne(User::className(), ["id" => "user_id"]);
    }

    public function Getpost()
    {
        return $this->hasMany(Post::className(), ["diary_id" => "id"])->orderBy('id');
        ;
    }


}