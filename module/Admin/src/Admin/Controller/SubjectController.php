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
use Admin\Service\SubjectService;
use Admin\Form\SubjectForm as SubjectForm;
use Zend\View\Model\JsonModel;

class SubjectController extends AbstractActionController
{

    protected $_subjectService;
    
    protected $_subjectForm;
    
    public function __construct(SubjectService $subjectService, SubjectForm $subjectForm)
    {
        $this->_subjectService = $subjectService;
        $this->_subjectForm = $subjectForm;
    }
    
    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/subject/overview.phtml')->setTerminal(true);
    
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
            $subjectHtml = $this->_subjectService->getSubjectsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $subjectHtml
            ));
        }
    }
    
    public function entryAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $htmlViewPart->setTerminal(true);
    
        if ($request->isXmlHttpRequest()) {
            if ($request->isPost()) {
                $post = $request->getPost();
                $status = $this->_subjectService->saveSubject($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $subjectData = $this->_subjectService->getEntityDataArray($params['id']);
                    return new JsonModel($subjectData);
                }
                return $htmlViewPart->setVariables(array(
                    'subjectForm' => $this->_subjectForm
                ));
            }
        }
    }
    
    public function delete($id)
    {
        return array();
    }
}
