<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Question\PaperService as QuestionPaperService;
use Admin\Form\Question\PaperForm as QuestionPaperForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestionPaperController extends AbstractActionController
{

    protected $_questionPaperService;

    protected $_questionSectionService;

    protected $_questionPaperForm;

    public function __construct(QuestionPaperService $questionPaperService, QuestionPaperForm $questionPaperForm)
    {
        $this->_questionPaperService = $questionPaperService;
        $this->_questionPaperForm = $questionPaperForm;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $questionPaperHtml = $this->_questionPaperService->getQuestionPapersHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $questionPaperHtml
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
                $status = $this->_questionPaperService->saveQuestionPaper($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $questionPaperData = $this->_questionPaperService->getEntityDataArray($params['id']);
                    return new JsonModel($questionPaperData);
                }
                return $htmlViewPart->setVariables(array(
                    'questionPaperForm' => $this->_questionPaperForm
                ));
            }
        }
    }

    public function delete($id)
    {
        return array();
    }

    public function paperAction(){
        $request = $this->getRequest();
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $examId = isset($post['id']) ? $post['id'] : null;
            $examPapers = $this->_questionPaperService->getExamPapers($examId);
            $papers = array();
            foreach ($examPapers as $ep) {
                $papers[] = [
                    'id' => $ep->getId(),
                    'value' => $ep->getPaperName()
                ];
            }
            return new JsonModel(array(
                'selected' => $papers,
                'status'  => count($papers) > 0 ? true : false
            ));
        }
    }
}
