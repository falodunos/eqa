<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\ExamService;
use Admin\Form\ExamForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ExamController extends AbstractActionController
{

    protected $_examService;

    protected $_exam_form;

    protected $_questionPaperService;
    
    public function __construct(ExamService $examService, ExamForm $exam_form)
    {
        $this->_examService = $examService;
        $this->_exam_form = $exam_form;
    }
    
    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/exam/overview.phtml')->setTerminal(true);
    
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
            $examHtml = $this->_examService->getExamsHtml();
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
                $status = $this->_examService->saveExam($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $examData = $this->_examService->getEntityDataArray($params['id']);
                    return new JsonModel($examData);
                }
                return $htmlViewPart->setVariables(array(
                    'examForm' => $this->_exam_form
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
