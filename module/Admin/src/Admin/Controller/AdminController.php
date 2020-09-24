<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\UserController;

class AdminController extends UserController
{

    public function indexAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/index/index.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }
    
    public function adminLoginAction(){
        
    }
}
