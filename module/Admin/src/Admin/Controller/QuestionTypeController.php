<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Question\TypeService as QuestionTypeService;
use Admin\Form\Question\TypeForm as QuestionTypeForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestionTypeController extends AbstractActionController
{
    protected $_questionTypeService;

    protected $_questionTypeForm;

    public function __construct(QuestionTypeService $questionTypeService, QuestionTypeForm $questionTypeForm)
    {
        $this->_questionTypeService = $questionTypeService;
        $this->_questionTypeForm = $questionTypeForm;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $questionTypeHtml = $this->_questionTypeService->getQuestionTypesHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $questionTypeHtml
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
                $status = $this->_questionTypeService->saveQuestionType($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) { 
                    $questionTypeData = $this->_questionTypeService->getEntityDataArray($params['id']);
                    return new JsonModel($questionTypeData);
                }
                return $htmlViewPart->setVariables(array(
                    'questionTypeForm' => $this->_questionTypeForm
                ));
            }
        }
    }

    public function delete($id)
    {
        return array();
    }
}
