<?php
namespace Application\View\Helper\Notification;

use Zend\View\Helper\AbstractHelper;

class FlashMessengerHelper extends AbstractHelper
{

    public function __invoke()
    {
//         if ($this->view->hasMessages()) {
            echo $this->view->flashMessenger()->render('error', array(
                'alert',
                'alert-danger'
            ));
            echo $this->view->flashMessenger()->render('success', array(
                'alert',
                'alert-success'
            ));
            echo $this->view->flashMessenger()->render('default', array(
                'alert',
                'alert-info'
            ));
            $this->view->flashMessenger()
                ->getPluginFlashMessenger()
                ->clearCurrentMessagesFromNamespace('default');
            $this->view->flashMessenger()
                ->getPluginFlashMessenger()
                ->clearCurrentMessagesFromNamespace('success');
            $this->view->flashMessenger()
                ->getPluginFlashMessenger()
                ->clearCurrentMessagesFromNamespace('error');
//         }
    }
}