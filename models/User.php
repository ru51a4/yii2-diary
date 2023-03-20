<?

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public static function tableName()
    {
        return 'users';
    }
    public function Getdiarys()
    {
        return $this->hasMany(Diary::className(), ["user_id" => "id"]);
    }

    private static $users = [
        '1' => [
            'id' => '1',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::find()->where(["id" => $id])->all()[0];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
		return static::find()
			->where(['id' => (string) $token->getClaim('uid') ])->one();
	}

    public function afterSave($isInsert, $changedOldAttributes) {
		// Purge the user tokens when the password is changed
		if (array_key_exists('usr_password', $changedOldAttributes)) {
			\app\models\UserRefreshToken::deleteAll(['urf_userID' => $this->userID]);
		}

		return parent::afterSave($isInsert, $changedOldAttributes);
	}

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}