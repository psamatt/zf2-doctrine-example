<?php
namespace Blog\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct(EntityManager $em)
    {
        parent::__construct('post');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'options' => array('label' => 'Title'),
            'attributes' => array(
                'class' => 'input-xxlarge'
            )
        ));

        $this->add(array(
            'name' => 'content',
            'type'  => 'textarea',
            'options' => array('label' => 'Content',),
        ));

        $this->add(array(
            'name' => 'category',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Category',
                'object_manager' => $em,
                'target_class' => 'Blog\Entity\Category',
                'property' => 'name'
            ),
            'attributes' => array(
                'required' => true
            )
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
