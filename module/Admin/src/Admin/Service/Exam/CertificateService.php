<?php
namespace Admin\Service\Exam;

use Admin\Service\Contract\Exam\CertificateServiceInterface;
use Admin\Entity\Contract\Exam\CertificateInterface;
use Admin\Repository\Exam\CertificateRepository;
use Base\Service\BaseService;
use Admin\Entity\Exam\Certificate;
use Zend\ServiceManager\ServiceLocatorInterface;

class CertificateService extends BaseService implements CertificateServiceInterface
{

    protected $_cert_repository;

    protected $_certEntity = null;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setCertificateRepository($this->getServiceLocator()
            ->get('examsqa_admin_certificate_repository'));
        
        if (is_null($this->_certEntity)) {
            $this->_certEntity = new Certificate();
        }
    }

    protected function _setCertificateRepository(CertificateRepository $cert_repository)
    {
        $this->_cert_repository = $cert_repository;
    }

    public function getCertificateRepository()
    {
        return $this->_cert_repository;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::saveExam()
     */
    public function saveCertificate($post)
    {
        // this action will perform both create and update operation on Certificate object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_certificate_form'); // Create the certificte form
        $cert_repository = $this->getCertificateRepository();
        $dateTime = new \DateTime("now");
        $id = $post['certificate-fieldset']['id'];
        if ($id) { // updating existing level entity ...
            $cert_repository->setEntityClass($this->_certEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData()->setUpdatedAt($dateTime);
                return $cert_repository->update($entity)->getId() ? true : false; // save modified entity to the database ...
            }
        } else { // creating new level entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                
                if($this->getAdminRoleId() == 'super-admin'){
                    $entity->setInstitution($this->getZfcUserIdentity()->getInstitution());
                }
                
                return $cert_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\CertificateServiceInterface::findAllCertificates()
     */
    public function findAllCertificates()
    {
        return $this->getCertificateRepository()->findAll();
    }
    
    public function findCertificateBy(array $criteria){
        return $this->getCertificateRepository()->findBy($criteria);
    }
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\CertificateServiceInterface::findCertificate()
     */
    public function findCertificate($id)
    {
        return $this->getCertificateRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\CertificateServiceInterface::deleteCertificate()
     */
    public function deleteCertificate(CertificateInterface $certificate)
    {
        // TODO Auto-generated method stub
    }

    public function getExamCertificatesHtml()
    {
        $path = '/module/Admin/view/admin/certificate/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        
        $institution = $this->getZfcUserIdentity()->getInstitution();
        
        foreach ($this->findCertificateBy(array('institution' => $institution)) as $cert) {
            $count += 1;
            $status = (int) $cert->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=certificate-edit-" . $cert->getId() . ">Edit</option>
                            <option value=certificate-delete-" . $cert->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $cert->getCertName() . "</td><td>" . $cert->getCertCode() . "</td><td>" . $cert->getCertDescription() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $cert = $this->findCertificate($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $cert->getId()
            ],
            [
                'id' => 'certName',
                'value' => $cert->getCertName()
            ],
            [
                'id' => 'certCode',
                'value' => $cert->getCertCode()
            ],
            [
                'id' => 'certDescription',
                'value' => $cert->getCertDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $cert->getIsActive()
            ]
        );
    }
}