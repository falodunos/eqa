<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Academic\DepartmentService;
use Admin\Form\Academic\DepartmentForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class DepartmentController extends AbstractActionController
{

    protected $_departmentService;

    protected $_departmentForm;

    public function __construct(DepartmentService $departmentService, DepartmentForm $departmentForm)
    {
        $this->_departmentService = $departmentService;
        $this->_departmentForm = $departmentForm;
    }

    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/department/overview.phtml')->setTerminal(true);
            
            return $htmlViewPart;
        }
        return array();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $examHtml = $this->_departmentService->getDepartmentsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $examHtml
            ));
        }
    }

    public function entryAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest) {
            if ($request->isPost()) {
                $post = $request->getPost();
                $status = $this->_departmentService->saveDepartment($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $examData = $this->_departmentService->getEntityDataArray($params['id']);
                    return new JsonModel($examData);
                }
                
                $userId = $this->zfcUserAuthentication()
                    ->getIdentity()
                    ->getId();
                
                $institution = $this->_departmentService->getInstitution($userId);
                if (! is_null($institution)) {
                    $instId = $institution->getId();
                    $this->_departmentForm->get('department-fieldset')
                        ->get('institution')
                        ->setValue($instId);
                }
                
                return $htmlViewPart->setVariables(array(
                    'departmentForm' => $this->_departmentForm
                ));
            }
        }
        return new ViewModel(array());
    }

    public function delete($id)
    {
        return array();
    }
}
