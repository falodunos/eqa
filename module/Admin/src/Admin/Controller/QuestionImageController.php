<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Question\ImageService as QuestionImageService;
use Admin\Form\Question\ImageForm as QuestionImageForm;
// use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class QuestionImageController extends AbstractActionController
{

    protected $_questionImageService;

    protected $_questionImageForm;

    public function __construct(QuestionImageService $questionImageService, QuestionImageForm $questionImageForm)
    {
        $this->_questionImageService = $questionImageService;
        $this->_questionImageForm = $questionImageForm;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $questionHtml = $this->_questionImageService->getQuestionsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $questionHtml
            ));
        }
    }

    public function uploadAction()
    {
        $viewmodel = new ViewModel();
        $form = $this->_questionImageForm;
        $request = $this->getRequest();
        $is_xmlhttprequest = $request->isXmlHttpRequest(); // check if request is ajax or not
        
        $viewmodel->setTerminal($is_xmlhttprequest); // disable layout if request is ajax
        if ($is_xmlhttprequest) {
            if ($request->isPost()) {
                $data = $request->getPost()->toArray();
                $file = $request->getFiles()->toArray();
                $post = array_merge_recursive($data, $file);
                
                if (isset($post['parentEntityId']) && (int) trim($post['parentEntityId']) > 0) { // initalizing image upload form and parentEntityId is the only data sent
                    $parentEntityId = (int) trim($post['parentEntityId']);
                    $viewmodel->setVariables(array(
                        'documentForm' => $form,
                        'parentEntityId' => $parentEntityId
                    ));
                } else {
                    $response = $this->_questionImageService->upload($form, $data, $file);
                    return new JsonModel(array(
                        'response' => $response
                    ));
                }
                
                return $viewmodel;
            }
        }
    }

    public function downloadAction()
    {
        $file = urldecode($this->params()->fromRoute('id'));
        $this->_questionImageService->download($file);
        return new ViewModel(array());
    }

    /**
     * Deleted image with from a given src
     *
     * @method deleteimageAction
     *        
     * @return bool
     */
    protected function deleteimageAction()
    {
        $request = $this->getRequest();
        $status = false;
        
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            
            if ($request->isXmlHttpRequest()) {
                if (is_file("public" . $data["img"])) {
                    $isDeleted = $this->_questionImageService->deleteImageTrailFromDb($data["img"]);
                    if ($isDeleted == true) {
                        unlink("public" . $data["img"]);
                        $status = true;
                    }
                }
            }
        }
        return $status;
        //e.g. $data["img"] = '\admin\img\examsqa\institutions\institution_1\departments\department_1\exams\exam_2\subjects\subject_1\papers\paper_2\sections\section_4\question_3\boxer.jpg'
    }

    /**
     * Get all files from all folders and list them in the gallery
     * getcwd() is there to make the work with images path easier
     *
     * @return JsonModel
     */
    protected function filesAction()
    {
        $request = $this->getRequest();
        $is_xmlhttprequest = $request->isXmlHttpRequest(); // check if request is ajax or not
        
        if ($is_xmlhttprequest) {
            if ($request->isPost()) {
                $post = $request->getPost()->toArray();
                
                if (isset($post['parentEntityId']) && (int) trim($post['parentEntityId']) > 0) { // initalizing image upload form and parentEntityId is the only data sent
                    $parentEntityId = (int) trim($post['parentEntityId']);
                    $response = $this->_questionImageService->getQuestionImages($post);
                    
                    return new JsonModel([
                        "files" => $response
                    ]);
                }
            }
        }
    }

    public function validatepostajaxAction()
    {
        $form = $this->getForm();
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $messages = array();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if (! $form->isValid()) {
                $errors = $form->getMessages();
                foreach ($errors as $key => $row) {
                    if (! empty($row) && $key != 'submit') {
                        foreach ($row as $keyer => $rower) {
                            $messages[$key][] = $rower;
                        }
                    }
                }
            }
            
            if (! empty($messages)) {
                $response->setContent(\Zend\Json\Json::encode($messages));
            } else {
                // save to db ;)
                $this->savetodb($form->getData());
                $response->setContent(\Zend\Json\Json::encode(array(
                    'success' => 1
                )));
            }
        }
        
        return $response;
    }
}
