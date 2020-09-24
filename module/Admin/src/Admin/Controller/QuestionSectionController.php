<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Question\SectionService as QuestionSectionService;
use Admin\Service\QuestionService;
use Admin\Form\Question\SectionForm as QuestionSectionForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestionSectionController extends AbstractActionController
{

    protected $_questionSectionService;

    protected $_questionService;

    protected $_questionSectionForm;

    public function __construct(QuestionSectionService $questionSectionService, QuestionSectionForm $questionSectionForm, QuestionService $questionService)
    {
        $this->_questionSectionService = $questionSectionService;
        $this->_questionSectionForm = $questionSectionForm;
        $this->_questionService = $questionService;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $questionSectionHtml = $this->_questionSectionService->getQuestionSectionsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $questionSectionHtml
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
                $status = $this->_questionSectionService->saveQuestionSection($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $questionSectionData = $this->_questionSectionService->getEntityDataArray($params['id']);
                    return new JsonModel($questionSectionData);
                }
                return $htmlViewPart->setVariables(array(
                    'questionSectionForm' => $this->_questionSectionForm
                ));
            }
        }
    }

    public function delete($id)
    {
        return array();
    }

    public function sectionAction()
    {
        $request = $this->getRequest();
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $paperId = isset($post['id']) ? $post['id'] : null;
            $paperSections = $this->_questionSectionService->loadPaperSections($paperId); 
            $sections = array();
            foreach ($paperSections as $ps) {
                $sections[] = [
                    'id' => $ps->getId(),
                    'value' => $ps->getSectionName()
                ];
            }
            return new JsonModel(array(
                'selected' => $sections,
                'status'  => count($sections) > 0 ? true : false
            ));
        }
    }
}
