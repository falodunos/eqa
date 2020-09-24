<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\QuestionService;
use Admin\Form\QuestionForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestionController extends AbstractActionController
{

    protected $_questionService;

    protected $_questionForm;

    public function __construct(QuestionService $questionService, QuestionForm $questionForm)
    {
        $this->_questionService = $questionService;
        $this->_questionForm = $questionForm;
    }

    public function overviewAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $htmlViewPart = new ViewModel();
            $htmlViewPart->setTemplate('admin/question/overview.phtml')->setTerminal(true);
            
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
            $questionHtml = $this->_questionService->getQuestionsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $questionHtml
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
                $status = $this->_questionService->saveQuestion($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $questionData = $this->_questionService->getEntityDataArray($params['id']);
                    return new JsonModel($questionData);
                }
                return $htmlViewPart->setVariables(array(
                    'questionForm' => $this->_questionForm
                ));
            }
        }
    }

    public function questionAction()
    {
        $request = $this->getRequest();
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $sectionId = isset($post['id']) ? $post['id'] : null;
            $sectionQuestions = $this->_questionService->getSectionQuestions($sectionId);
            $questions = array();
            foreach ($sectionQuestions as $sq) {
                $questions[] = [
                    'id' => $sq->getId(),
                    'value' => $sq->getQuestionTag()
                ];
            }
            return new JsonModel(array(
                'selected' => $questions,
                'status' => count($questions) > 0 ? true : false
            ));
        }
    }

    public function questionTagAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost()->toArray();
        $questionTag = $this->_questionService->getQuestionTag($post);
        
        return new JsonModel(array(
            'questionTag' => $questionTag
        ));
    }

    public function delete($id)
    {
        return array();
    }
}
