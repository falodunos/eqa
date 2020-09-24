<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Controller\QuestionPaperController as AdminQuestionPaperController;
use Zend\ServiceManager\ServiceManager;

class QuestionPaperController extends AdminQuestionPaperController
{
    protected $_questionPaperService, $_institutionService, $_subjectService, $_questionService;

    protected $_examsqaSession, $_examService, $_answerOptionService, $_questionImageService;

    public function __construct(ServiceManager $sm)
    {
        $this->_questionPaperService = $sm->get('examsqa_admin_question_paper_service');
        $this->_examsqaSession = $sm->get('examsqa_session');
        $this->_institutionService = $sm->get('examsqa_admin_institution_service');
        $this->_subjectService = $sm->get('examsqa_admin_subject_service');
        $this->_examService = $sm->get('examsqa_admin_exam_service');
        $this->_questionService = $sm->get('examsqa_admin_question_service');
        $this->_answerOptionService = $sm->get('examsqa_admin_answer_option_service');
        $this->_questionImageService = $sm->get('examsqa_admin_question_image_service');
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

    public function getExamsOfferingThisSubjectAction()
    {
        $request = $this->getRequest();
        $subjectId = $request->getQuery('subjectId');
        $htmlViewPart = new ViewModel();
        if ($request->isXmlHttpRequest() && ! is_null($this->_examsqaSession)) {
            $htmlViewPart->setTerminal(true);
            
            $institutionId = $this->_examsqaSession->selectedInstitutionId = $this->_examsqaSession->featuredSubjectsInstId;
            $requiredExams = $this->_questionPaperService->getExamsOfferingThisSubject($institutionId, $subjectId);
            
            $institution = $this->_institutionService->findInstitution($institutionId);
            
            $subject = $this->_subjectService->findSubject($subjectId);
            $this->_examsqaSession->selectedSubjectId = $subject->getId();
            
            $htmlViewPart->setVariables([
                'institution' => $institution,
                'subject' => $subject,
                'exams' => $requiredExams
            ]);
            
            return $htmlViewPart->setTemplate('application/question-paper/exams.phtml');
        }
    }

    public function getYearsOfQuestionPapersAction()
    {
        $request = $this->getRequest();
        $examId = $request->getQuery('examId');
        $exam = $this->_examService->findExam($examId);
        $this->_examsqaSession->selectedSubjectExamId = $examId;
        $htmlViewPart = new ViewModel();
        
        if ($request->isXmlHttpRequest() && ! is_null($this->_examsqaSession)) {
            $htmlViewPart->setTerminal(true);
            $criteria = [
                'paperSubject' => $this->_examsqaSession->selectedSubjectId,
                'institution' => $this->_examsqaSession->selectedInstitutionId,
                'paperExam' => $exam
            ];
            
            $allQP4ThisSubject = $this->_questionPaperService->findQuestionPaperBy($criteria);
            
            $this->_examsqaSession->allQP4ThisSubject = $allQP4ThisSubject;
            
            $htmlViewPart->setVariables([
                'allQP4ThisSubject' => $allQP4ThisSubject
            ]);
            
            return $htmlViewPart->setTemplate('application/question-paper/years.phtml');
        }
    }

    public function startAction()
    {
        $request = $this->getRequest();
        
        if ($this->zfcUserAuthentication()->hasIdentity() && $request->isPost()) {
            $post = $this->getRequest()
                ->getPost()
                ->toArray();
            
            $subjectExamYearSelected = $post['subjectExamYearSelected'];
            $institution = $this->_institutionService->findInstitution($this->_examsqaSession->selectedInstitutionId);
            $subject = $this->_subjectService->findSubject($this->_examsqaSession->selectedSubjectId);
            $exam = $this->_examService->findExam($this->_examsqaSession->selectedSubjectExamId);
            $this->_examsqaSession->subjectExamYearSelected = $subjectExamYearSelected;
            
            $criteria = [
                'paperSubject' => $subject,
                'institution' => $institution,
                'paperExam' => $exam
            ];
            
            $allQP4ThisSubject = $this->_questionPaperService->findQuestionPaperBy($criteria);
            $this->_examsqaSession->currentPaperId = $allQP4ThisSubject[0]->getId();
            return new ViewModel([
                'institution' => $institution,
                'exam' => $exam,
                'subject' => $subject,
                'papers' => $allQP4ThisSubject
            ]);
        }
        
        return $this->redirect()->toRoute('zfcuser');
    }

    public function questionAction()
    {
        $request = $this->getRequest(); 
        $post = $request->getPost();
        
        $next = !is_null($post['targetQuestion']) && $post['targetQuestion'] == 'next';
        $previous = !is_null($post['targetQuestion']) && $post['targetQuestion'] == 'previous';
        
        $criteria = [
            'paperYear' => $this->_examsqaSession->subjectExamYearSelected,
            'paperExam' => $this->_examsqaSession->selectedSubjectExamId,
            'paperSubject' => $this->_examsqaSession->selectedSubjectId,
            'institution' => $this->_examsqaSession->selectedInstitutionId
        ];
        
        $this->_examsqaSession->paperCriteria = $criteria;
        $papers = $this->_questionPaperService->findQuestionPaperBy($criteria);
        $questions = $this->_questionService->findQuestionsBy([
            'questionPaper' => $this->_examsqaSession->currentPaperId
        ]);
        
        if ($request->isPost()) { 
            if (!$next && !$previous && $this->_examsqaSession->initialQuestionIndex <= 1){
                $this->_examsqaSession->initialQuestionIndex = 1;
                $this->_examsqaSession->currentQuestionIndex = $this->_examsqaSession->initialQuestionIndex - 1;                
            }else{
                if ($next == true && $this->_examsqaSession->currentQuestionIndex < count($questions)-1){
                    $this->_examsqaSession->currentQuestionIndex += 1;
                }
                
                if($previous == true && $this->_examsqaSession->currentQuestionIndex > 0){
                    $this->_examsqaSession->currentQuestionIndex -= 1;
                }
            }       


            return new ViewModel([
                'institution' => $this->_institutionService->findInstitution($this->_examsqaSession->selectedInstitutionId),
                'subject' => $this->_subjectService->findSubject($this->_examsqaSession->selectedSubjectId),
                'exam' => $this->_examService->findExam($this->_examsqaSession->selectedSubjectExamId),
                'year' => $this->_examsqaSession->subjectExamYearSelected,
                'paper' => $papers[0],
                'questions' => $questions,
                'currentQuestionIndex' => $this->_examsqaSession->currentQuestionIndex,
                'answerOptionService' => $this->_answerOptionService,
                'questionImageService' => $this->_questionImageService
            ]);
    }
        
        if ((int) $this->_examsqaSession->initialQuestionIndex != 0) {
            return new ViewModel([
                'institution' => $this->_institutionService->findInstitution($this->_examsqaSession->selectedInstitutionId),
                'subject' => $this->_subjectService->findSubject($this->_examsqaSession->selectedSubjectId),
                'exam' => $this->_examService->findExam($this->_examsqaSession->selectedSubjectExamId),
                'year' => $this->_examsqaSession->subjectExamYearSelected,
                'paper' => $papers[0],
                'questions' => $questions,
                'currentQuestionIndex' => $this->_examsqaSession->currentQuestionIndex,
                'answerOptionService' => $this->_answerOptionService,
                'questionImageService' => $this->_questionImageService
            ]);
        }
        
        return $this->redirect()->toRoute('zfcuser');
    }
    
    public function getAnswerAndExplanationAction(){
        $request = $this->getRequest();
        $questionId = $request->getQuery('questionId');
        $htmlViewPart = new ViewModel();
        if ($request->isXmlHttpRequest() && ! is_null($this->_examsqaSession)) {
            $htmlViewPart->setTerminal(true);
            
            $question = $this->_questionService->findQuestion($questionId);
            $htmlViewPart->setVariables([
                'options' => $question->getOptions()
            ]);
       
            return $htmlViewPart->setTemplate('application/question-paper/explanation.phtml');
        }
    }
    
    public function showQuestionCommentsAction(){
        $request = $this->getRequest();
        $htmlViewPart = new ViewModel();
        if ($request->isXmlHttpRequest() && ! is_null($this->_examsqaSession)) {
            $htmlViewPart->setTerminal(true);
            return $htmlViewPart->setTemplate('application/question-paper/comment.phtml');
        }
    }
}
