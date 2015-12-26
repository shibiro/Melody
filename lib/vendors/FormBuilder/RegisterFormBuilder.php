<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use OCFram\MailValidator;
use OCFram\PasswordField;
use OCFram\SimilarValidator;
use \OCFram\StringField;
use \OCFram\MaxLengthValidator;
use \OCFram\VerifyNewUsernameValidator;
use \OCFram\VerifyPriorityValidator;
use \OCFram\VerifyPasswordValidator;
use \OCFram\NotNullValidator;

class RegisterFormBuilder extends FormBuilder
{
    public function build()
    {
        $username = new StringField([
            'label' => 'Username',
            'name' => 'username',
            'maxLength' => 20,
            'validators' => [
                new MaxLengthValidator('Le pseudo spécifie est trop long(20 caratères maximum)', 20),//pseudo trop long
                new NotNullValidator('Je dois deviner ton pseudo?'),
                new VerifyNewUsernameValidator('Ce pseudo est pris',func_get_arg(0)), // le message d'erreur ne s'affiche pas
                // vérifié que le pseudo n'est pas utilisé
            ],
        ]);

        $this->form->add($username );

        $password = new PasswordField([
            'label' => 'Password',
            'name' => 'password',
            'maxLength' => 30,
            'validators' => [
                new MaxLengthValidator('Le mdp spécifié est trop long (100 caractères maximum)', 30),// vérifier que le mdp pour le pseudo est valide
                new NotNullValidator('Je dois deviner ton mot de passe ? '),
                //mettre un format de mdp ?
                ],
        ]);

        $this->form->add($password);

        $confirmation = new PasswordField([
            'label' => 'Confirmation',
            'name' => 'confirmation',
            'maxLength' => 30,
            'validators' => [
                new SimilarValidator('Les mots de passes ne correspondent pas',$password->value())
                                //vérifier que c'est le même mdp qu'audessus ($password->value()
            ],
        ]);

        $this->form->add($confirmation);
        //     new VerifyPseudoValidator('Le pseudo spécifié n\'existe pas'),

        $description = new StringField([
            'label' => 'Description',
            'name' => 'description',
            'maxLength' => 250,
            'validators' => [
                //mettre a jour les messages d'erreurs, et les critères que l'on souhaite.
                new MaxLengthValidator('Ta décription est trop longue, ne sois pas si bavard(250 caratères maximum)', 249),//pseudo trop long
                new NotNullValidator('Si tu pouvais te décrire se serait sympa pour tes amis'),
            ],
        ]);

        $this->form->add($description);

        $mail = new StringField([
        'label' => 'Mail',
        'name' => 'mail',
        'maxLength' => 200,
        'validators' => [
            //mettre a jour les messages d'erreurs, et les critères que l'on souhaite.
            new MaxLengthValidator('Ton mail est trop long', 200),//pseudo trop long
            new NotNullValidator('On aurait besoin de te contacter par mail'),
            new MailValidator('Ton mail n\'a pas le bon format')
            // validator de format mail
            ],
        ]);

        $this->form->add($mail);
    }
}