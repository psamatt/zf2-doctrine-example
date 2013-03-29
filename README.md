# Zend Framework 2 with Doctrine example application using ZendForm

## Introduction
This is an example application that encompasses the benefits of ZF2 with Doctrine but with clearly demonstrative code of how to interact Doctrine entity relationships with Zend Form. There are many guides you can follow to integrate Doctrine with ZF2 such as [James Grimes' guide](http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/) which is also mentioned on Rob Allen's blog, however I found any documentation on utilising both of these technologies with Zend Form hard to find, so I've written a small application that everyone can hopefully use to get them going with building their application using the wonders of an ORM.

Assuming you've followed James Grimes guide, you will have a small application that will add, edit and delete objects. However how about if you wish to use Doctrine relations inside your Zend Form object?

### Lets get stuck in

Firstly, you need to create your relationships in your entities as usual, then in your Zend Form file, you will need to specify the element name as the same name as the entity property name you gave you relationship, then ensure your type is of `DoctrineModule\Form\Element\ObjectSelect`, `DoctrineModule\Form\Element\ObjectRadio` or `DoctrineModule\Form\Element\ObjectMultiCheckbox`. For this to work, you will need to specify at least an `object_manager`, the `target_class` to use and a property of the class to use as the Label.

As many tutorials build the form in the Form constructor, I'm following this method but have passed the entity manager object instance as a dependency into the Form constructor to then use as the object_manager value. The `target_class` will be the class name including the namespace of the class to find elements form, an example of this can be found in the [Post Form](https://github.com/psamatt/zf2-doctrine-example/blob/master/module/Blog/src/Blog/Form/PostForm.php)

Once you've added all the necessary properties of the Form element, you will then need to add all the getters and setters for the Entity you've created the Form based upon, this is an essential part of Doctrine working alongside Zend Form. In addition to this, you will need to change the Hydrator of the Form object to the Doctrine instance in your [controller](https://github.com/psamatt/zf2-doctrine-example/blob/master/module/Blog/src/Blog/Controller/PostController.php#L40), this will populate all elements of the Form including any relationship properties used. 

    $form->setHydrator(new DoctrineEntity($this->getEntityManager(),'path\to\my\entity'));
    
Once you've added the correct hydrator, you will now see all your saved values appear in the form and thats it, you've successfully integrated Doctrine with Zend Form :-)

#### Versions Used

* doctrine/common                  2.3.0
* doctrine/dbal                    2.3.2
* doctrine/doctrine-module         0.7.1
* doctrine/doctrine-orm-module     0.7.0
* doctrine/orm                     2.3.2
* symfony/console                  v2.2.0
* zendframework/zendframework      2.1.3