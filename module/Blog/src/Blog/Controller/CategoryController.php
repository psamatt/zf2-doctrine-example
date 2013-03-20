<?php

namespace Blog\Controller;

use Application\Controller\EntityUsingController;
use Zend\View\Model\ViewModel;

use Blog\Form\CategoryForm;
use Blog\Entity\Category;

class CategoryController extends EntityUsingController
{
    /**
    *
    *
    */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $categories = $em->getRepository('Blog\Entity\Category')->findBy(array(), array('name' => 'ASC'));

        return new ViewModel(array('categories' => $categories,));
    }

    public function editAction()
    {
        $category = new Category;

        if ($this->params('id') > 0) {
            $category = $this->getEntityManager()->getRepository('Blog\Entity\Category')->find($this->params('id'));
        }

        $form = new CategoryForm();
        $form->bind($category);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($category);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Category Saved');

                return $this->redirect()->toRoute('category');
            }
        }

        return new ViewModel(array(
            'category' => $category,
            'form' => $form
        ));
    }

    public function addAction()
    {
        return $this->editAction();
    }

    public function deleteAction()
    {
        $category = $this->getEntityManager()->getRepository('Blog\Entity\Category')->find($this->params('id'));

        if ($category) {
            $em = $this->getEntityManager();
            $em->remove($category);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('Category Deleted');
        }

        return $this->redirect()->toRoute('category');
    }
}
