<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\MaxLengthValidator;
use \OCFram\MaxLengthWordValidator;

class TagFormBuilder extends FormBuilder
{
    public function build()
    {
        $name = new StringField([
            'label' => 'Tag',
            'name' => 'name',
            'validators' => [
                new MaxLengthValidator('le nombre de caractère pour tout les tags est excédé (max 140))', 140),//pseudo trop long14
                new MaxLengthWordValidator('le nombre de caractère pour un tag est excédé (max 30))', 30),//pseudo trop long14
            ],
        ]);
        $this->form->add($name);
    }
}