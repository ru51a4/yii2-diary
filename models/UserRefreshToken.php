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
class UserRefreshToken extends ActiveRecord
{

    public static function tableName()
    {
        return 'user_refresh_tokens';
    } 
}