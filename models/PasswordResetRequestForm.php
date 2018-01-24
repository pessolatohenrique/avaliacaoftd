<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required','message' => 'O campo e-mail é de preenchimento obrigatório'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Não existe usuário com este endereço de e-mail.'
            ],
        ];
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->email,
        ]);
        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            //var_dump($user->generatePasswordResetToken()); die;
            if (!$user->save(false)) {
                return false;
            }
        }
        return Yii::$app
            ->mailer
            ->compose(
                'html',['user' => $user]
                //['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                //['user' => $user]
            )
            ->setFrom("pessolatohenrique@gmail.com")
            ->setTo($this->email)
            ->setSubject('Senha reiniciada para Avaliação FTD')
            ->send();
    }
}