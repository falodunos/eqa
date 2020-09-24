<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\DashboardService;
use Zend\View\Model\ViewModel;
// use Zend\View\Model\JsonModel;

class DashboardController extends AbstractActionController
{

    protected $_dashService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->_dashService = $dashboardService;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            
            return $htmlViewPart->setTerminal(true);
        }
        return array();
    }

}
