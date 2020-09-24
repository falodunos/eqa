<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Exam\LevelService;
use Admin\Form\Exam\LevelForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class LevelController extends AbstractActionController
{

    protected $_levelService;

    protected $_level_form;

    public function __construct(LevelService $levelService, LevelForm $level_form)
    {
        $this->_levelService = $levelService;
        $this->_level_form = $level_form;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $levelHtml = $this->_levelService->getLevelsHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $levelHtml
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
                $status = $this->_levelService->saveLevel($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $levelData = $this->_levelService->getEntityDataArray($params['id']);
                    return new JsonModel($levelData);
                }
                return $htmlViewPart->setVariables(array(
                    'levelForm' => $this->_level_form
                ));
            }
        }
    }

    public function delete($id)
    {
        return array();
    }
}
