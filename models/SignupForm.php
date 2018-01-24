<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password; //atributo para confirmar a senha
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','message' => 'O campo usuário é de preenchimento obrigatório'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Este usuário já existe em nossa base de dados'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required','message' => 'O campo email é de preenchimento obrigatório'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Este e-mail já existe em nossa base de dados'],
            ['password', 'required','message' => 'O campo senha é de preenchimento obrigatório'],
            ['password', 'string', 'min' => 4],
            ['confirm_password', 'required', 'message' => 'A confirmação da senha não pode ficar em branco'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"A confirmação da senha deve ser igual a senha informada" ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'password' => 'Senha',
            'confirm_password' => 'Confirme a senha'
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save(false) ? $user : null;
    }
}