<?php

namespace Blog\Controller;

use Application\Controller\EntityUsingController;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\View\Model\ViewModel;

use Blog\Form\PostForm;
use Blog\Entity\Post;

class PostController extends EntityUsingController
{
    /**
    * Index action
    *
    */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $posts = $em->getRepository('Blog\Entity\Post')->findBy(array(), array('title' => 'ASC'));

        return new ViewModel(array('posts' => $posts,));
    }

    /**
    * Edit action
    *
    */
    public function editAction()
    {
        $post = new Post;

        if ($this->params('id') > 0) {
            $post = $this->getEntityManager()->getRepository('Blog\Entity\Post')->find($this->params('id'));
        }

        $form = new PostForm($this->getEntityManager());
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),'Blog\Entity\Post'));
        $form->bind($post);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em = $this->getEntityManager();

                $em->persist($post);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Post Saved');

                return $this->redirect()->toRoute('post');
            }
        }

        return new ViewModel(array(
            'post' => $post,
            'form' => $form
        ));
    }

    /**
    * Add action
    *
    */
    public function addAction()
    {
        return $this->editAction();
    }

    /**
    * Delete action
    *
    */
    public function deleteAction()
    {
        $post = $this->getEntityManager()->getRepository('Blog\Entity\Post')->find($this->params('id'));

        if ($post) {
            $em = $this->getEntityManager();
            $em->remove($post);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('Post Deleted');
        }

        return $this->redirect()->toRoute('post');
    }
}
