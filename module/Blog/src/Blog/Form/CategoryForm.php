<?php
namespace Blog\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
    public function __construct()
    {
        parent::__construct('category');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'type'  => 'text',
            'options' => array('label' => 'Name',),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
