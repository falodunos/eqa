<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\Exam\CertificateService;
use Admin\Form\Exam\CertificateForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CertificateController extends AbstractActionController
{

    protected $_certificateService;

    protected $_certificate_form;

    public function __construct(CertificateService $certificateService, CertificateForm $certificate_form)
    {
        $this->_certificateService = $certificateService;
        $this->_certificate_form = $certificate_form;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $path = null;
        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $post = $request->getPost()->toArray();
            $certHtml = $this->_certificateService->getCertificatesHtml();
            return new JsonModel(array(
                'status' => true,
                'html' => $certHtml
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
                $status = $this->_certificateService->saveCertificate($post);
                return new JsonModel(array(
                    'status' => $status
                ));
            } else {
                $params = $request->getQuery();
                if (isset($params['id'])) {
                    $certData = $this->_certificateService->getEntityDataArray($params['id']);
                    return new JsonModel($certData);
                }
                return $htmlViewPart->setVariables(array(
                    'certificateForm' => $this->_certificate_form
                ));
            }
        }
    }

    public function delete($id)
    {
        return array();
    }
}
