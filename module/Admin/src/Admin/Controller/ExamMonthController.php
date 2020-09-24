<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Exam\MonthService as ExamMonthService;
use Admin\Form\Exam\MonthForm as ExamMonthForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ExamMonthController extends AbstractActionController
{

    protected $_examMonthService;

    protected $_examMonthForm;

    public function __construct(ExamMonthService $examMonthService, ExamMonthForm $examMonthForm)
    {
        $this->_examMonthService = $examMonthService;
        $this->_examMonthForm = $examMonthForm;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $examMonthHtml = $this->_examMonthService->getExamMonthsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $examMonthHtml
            ));
        }
    }

    public function delete($id)
    {
        return array();
    }

    public function entryAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($request->isXmlHttpRequest()) {
            if ($request->isPost()) {
                $post = $request->getPost();
                $status = $this->_examMonthService->saveExamMonth($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $examMonthData = $this->_examMonthService->getEntityDataArray($params['id']);
                    return new JsonModel($examMonthData);
                }
                return $htmlViewPart->setVariables(array(
                    'examMonthForm' => $this->_examMonthForm
                ));
            }
        }
        
        return $htmlViewPart->setVariables(array('examMonthForm' => $this->_examMonthForm));
    }
}
