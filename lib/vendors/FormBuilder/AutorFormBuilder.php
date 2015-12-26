<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use OCFram\PasswordField;
use \OCFram\StringField;
use \OCFram\MaxLengthValidator;
use \OCFram\VerifyUsernameValidator;
use \OCFram\VerifyPriorityValidator;
use \OCFram\VerifyPasswordValidator;
use \OCFram\NotNullValidator;

class AutorFormBuilder extends FormBuilder
{
    public function build()
    {
        $username = new StringField([
            'label' => 'Username',
            'name' => 'username',
            'maxLength' => 20,
            'validators' => [
                new MaxLengthValidator('Le pseudo sp�cifie est trop long(20 carat�res maximum)', 20),//pseudo trop long
                new NotNullValidator('Je dois deviner ton pseudo?'),
                new VerifyUsernameValidator('Ton pseudo n\'est pas bon',func_get_arg(0)), // le message d'erreur ne s'affiche pas
            ],
        ]);

        $this->form->add($username );

        $password = new PasswordField([
            'label' => 'Password',
            'name' => 'password',
            'maxLength' => 30,
            'validators' => [
                new MaxLengthValidator('Le mdp sp�cifi� est trop long (100 caract�res maximum)', 30),// v�rifier que le mdp pour le pseudo est valide
                new NotNullValidator('Je dois deviner ton mot de passe ? '),
                new VerifyPasswordValidator('C\'est pas le bon mot de passe bro',func_get_arg(0),$username->value()),
            ],
        ]);

        $this->form->add($password);
        //     new VerifyPseudoValidator('Le pseudo sp�cifi� n\'existe pas'),
    }
}