<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\ServiceManager\ServiceLocatorInterface;

class QuestionCommentController extends AbstractActionController
{

    protected $_commentService;

    protected $_userIdentityService;

    protected $_userService;

    protected $_serviceLocator;

    protected $_commentForm;

    protected $_examsqaSession;

    protected $_questionRepository;

    public function __construct(ServiceLocatorInterface $serviceLocator, $commentForm)
    {
        $this->_serviceLocator = $serviceLocator->getServiceLocator();
        $this->_userService = $this->_serviceLocator->get('examsqa_application_user_service');
        $this->_commentService = $this->_serviceLocator->get('examsqa_application_question_comment_service');
        $this->_userIdentityService = $this->_serviceLocator->get('examsqa_application_user_identity_service');
        $this->_commentForm = $commentForm;
        $this->_examsqaSession = $this->_serviceLocator->get('examsqa_session');
        $this->_questionRepository = $this->_serviceLocator->get('examsqa_admin_question_repository');
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        $isXmlHttpRequest = $request->isXmlHttpRequest();
        $htmlViewPart->setTerminal($isXmlHttpRequest);
        
        if ($isXmlHttpRequest && $request->isPost()) {
            $post = $request->getPost();
            $status = $this->_commentService->addComment($post);
            return new JsonModel(array(
                'status' => $status
            ));
        }
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $isXmlHttRequest = $request->isXmlHttpRequest();
        $htmlViewPart = new ViewModel();
        $htmlViewPart->setTerminal($isXmlHttRequest);
        
        if ($isXmlHttRequest) {
            $questionId = $request->getQuery()->questionId;
            $question = $this->_questionRepository->find($questionId);
            $comments = $this->_commentService->getComments($question);
            
            return $htmlViewPart->setVariable('comments', $comments);
        }
        
        return [];
    }
}
