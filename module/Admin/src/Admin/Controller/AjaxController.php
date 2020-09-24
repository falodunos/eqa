<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AjaxController extends AbstractActionController
{

    public function dashboardAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/dashboard.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function examlevelAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/exam/examlevel.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function examcertificateAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/exam/examcertificate.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function exambodyAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/exam/exambody.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function examoverviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/exam/examoverview.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function subjectoverviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/subject/subjectoverview.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function subjectAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/subject/subject.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }
    
    public function useroverviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/user/useroverview.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function permissionoverviewAction()
    {
    $request = $this->getRequest();
    if ($request->isXmlHttpRequest()) {
        $htmlViewPart = new ViewModel();
        $htmlViewPart->setTemplate('admin/ajax/permission/permissionoverview.phtml')->setTerminal(true);
    
        return $htmlViewPart;
    }
    return array();
    }
    
    public function allusersAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/user/allusers.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    public function allrolesAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/permission/allroles.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function userentryAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/user/userentry.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function roleentryAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/permission/roleentry.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function questionoverviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/question/questionoverview.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function questionsectionAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/question/questionsection.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function questionAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/question/question.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
    public function questionpaperAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/ajax/question/questionpaper.phtml')->setTerminal(true);
    
            return $htmlViewPart;
        }
        return array();
    }
    
}
