<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Answer\OptionService as AnswerOptionService;
use Admin\Form\Answer\OptionForm as AnswerOptionForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AnswerOptionController extends AbstractActionController
{

    protected $_answerOptionService;

    protected $_answerOptionform;

    public function __construct(AnswerOptionService $answerOptionService, AnswerOptionForm $answerOptionForm)
    {
        $this->_answerOptionService = $answerOptionService;
        $this->_answerOptionform = $answerOptionForm;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $answerOptionsHhtml = $this->_answerOptionService->getAnswerOptionsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $answerOptionsHhtml
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
                $status = $this->_answerOptionService->saveAnswerOption($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $answerOptionData = $this->_answerOptionService->getEntityDataArray($params['id']);
                    return new JsonModel($answerOptionData);
                }
                return $htmlViewPart->setVariables(array(
                    'answerOptionForm' => $this->_answerOptionform
                ));
            }
        }
    }

    public function getQuizAnswerOptionsAction()
    {
        $request = $this->getRequest();
        
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost();
            $options = $this->_answerOptionService->getAnswerOptions($post);
            return new JsonModel($options);
        }
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray(); 
            $deleteStatus = $this->_answerOptionService->deleteAnswerOption($postData['option_id']);
            return new JsonModel(array(
                'status' => $deleteStatus == true ? true : false 
            ));
        }
    }
    
    public function updateActiveStatusAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray();
            $updateStatus = $this->_answerOptionService->updateActiveStatus($postData);
            return new JsonModel(array(
                'status' => $updateStatus == true ? true : false
            ));
        }
    }
    
    public function updateCorrectStatusAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray();
            $correctStatus = $this->_answerOptionService->updateCorrectStatus($postData);
            return new JsonModel(array(
                'status' => $correctStatus == true ? true : false
            ));
        }
    }
    
    public function updateTextAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost()->toArray();
            if(isset($postData['questionText']) && !empty($postData['questionText'])){
                $correctStatus = $this->_answerOptionService->updateOptionText($postData);
                return new JsonModel(array(
                    'status' => $correctStatus == true ? true : false
                ));
            }else{
                $tinymce = $this->_answerOptionService->getTinyMCEtextarea($postData);
                $response = $this->getResponse();
                $response->setContent($tinymce); 
                $response->getHeaders()->addHeaders(array('Content-Type'=>'application/html; charset=utf-8'));
                return $response;
            }
        }
    }
    
}
