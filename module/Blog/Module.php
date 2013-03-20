<?php

namespace Blog;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $em = $e->getApplication()->getEventManager();

        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function($e) {

            $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();

            if ($flashMessenger->hasSuccessMessages()) {
                $e->getViewModel()->setVariable('successMessages', $flashMessenger->getSuccessMessages());
            }

        });
    }

    public function getServiceConfig()
    {

    }
}
