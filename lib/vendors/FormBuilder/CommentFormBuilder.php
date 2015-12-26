<?php
namespace FormBuilder;
 
use OCFram\CaractereValidator;
use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\MailValidator;
use \OCFram\MCaractereValidator;
 
class CommentFormBuilder extends FormBuilder
{
  public function build()
  {
      if(isset($_SESSION['user']) )
      {
          $contenu = new TextField([
              'label' => 'Contenu',
              'name' => 'contenu',
              'rows' => 7,
              'cols' => 50,
              'validators' => [
                  new NotNullValidator('Merci de spécifier votre commentaire'),

              ],
          ]);

          $this->form->add($contenu);
      }
      else if(true)
      {
          $auteur = new StringField([
              'label' => 'Auteur',
              'name' => 'auteur',
              'maxLength' => 20,
              'validators' => [
                  new MaxLengthValidator('Le pseudo spécifie est trop long(20 caratères maximum)', 20),//pseudo trop long
                  new NotNullValidator('Je dois deviner ton pseudo?'),
                  new CaractereValidator('Un des caractères n\'a pas le bon format')
              ],
          ]);

          $this->form->add($auteur );

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

          $contenu = new TextField([
          'label' => 'Contenu',
          'name' => 'contenu',
          'rows' => 7,
          'cols' => 50,
          'validators' => [
              new NotNullValidator('Merci de spécifier votre commentaire'),

            ],
          ]);

          $this->form->add($contenu);
      }
  }
}