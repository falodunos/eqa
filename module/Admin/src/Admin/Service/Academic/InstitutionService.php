<?php
namespace Admin\Service\Academic;

use Admin\Service\Contract\Academic\InstitutionServiceInterface;
use Admin\Repository\Academic\InstitutionRepository;
use Base\Service\BaseService;
use Admin\Entity\Academic\Institution;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Contract\Academic\InstitutionInterface;

class InstitutionService extends BaseService implements InstitutionServiceInterface
{

    protected $_institutionRepository;

    protected $_institutionEntity;

    protected $_zfcUserAuth;

    protected $_userIdentityService;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setInstitutionRepository($this->getServiceLocator()
            ->get('examsqa_admin_institution_repository'));
        
        if (is_null($this->_institutionEntity)) {
            $this->_institutionEntity = new Institution();
        }
        
        $this->_zfcUserAuth = $serviceLocator->get('zfcuser_auth_service');
        
        $this->_userIdentityService = $serviceLocator->get('examsqa_application_user_identity_service');
    }

    protected function _setInstitutionRepository(InstitutionRepository $examsqa_institution_repository)
    {
        $this->_institutionRepository = $examsqa_institution_repository;
    }

    public function getInstitutionRepository()
    {
        return $this->_institutionRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\InstitutionServiceInterface::findInstitution()
     */
    public function findInstitution($id)
    {
        return $this->getInstitutionRepository()->findById($id);
    }

    public function getInstitutionFromAuthService()
    {
        // var_dump($this->getZfcUserIdentity()); die;
        return $this->getZfcUserIdentity()
            ->getIdentity()
            ->getInstitution();
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\Contract\BaseServiceInterface::findBy()
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getInstitutionRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\InstitutionServiceInterface::findOneInstitutionBy()
     */
    public function findOneInstitutionBy(array $criteria, $orderBy = null)
    {
        return $this->getInstitutionRepository()->findOneBy($criteria, $orderBy);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\InstitutionServiceInterface::deleteInstitution()
     */
    public function deleteInstitution(InstitutionInterface $institution)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\InstitutionServiceInterface::findInstitutions()
     */
    public function findAllInstitutions()
    {
        return $this->getInstitutionRepository()->findAll();
    }

    public function getInstitution($userId)
    {
        $institution = $this->_institutionRepository->findBy(array(
            'user' => $userId
        ));
        return $institution;
    }

    public function saveInstitution($post)
    {
        // this action will perform both create and update operation an Institution object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_institution_form'); // Create the exam form
        $institution_repository = $this->getInstitutionRepository();
        $dateTime = new \DateTime("now");
        
        $id = $post['institution-fieldset']['id'];
        
        if ($id) { // updating existing QeustionType entity ...
            $institution_repository->setEntityClass($this->_institutionEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $institution_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new question type entity
            $isExisting = $this->checkIfInstitutionExist();
            if ($isExisting == false) {
                $form->setData($post);
                if ($form->isValid()) {
                    $entity = $form->getData();
                    $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                    $institution = $institution_repository->insert($entity);
                    $isSuccessful = $institution->getId() ? true : false;
                    if ($isSuccessful) {
                        $userIdentity = $this->_zfcUserAuth->getIdentity()
                            ->getIdentity()
                            ->setInstitution($institution);
                        
                        $this->_userIdentityService->updateIdentity($userIdentity);
                    }
                    return $isSuccessful;
                }
            } else { // if this user has an institution associated already return false for new registration only
                return false;
            }
        }
    }

    public function checkIfInstitutionExist()
    {
        if ($this->_zfcUserAuth->hasIdentity()) {
            $userId = $this->_zfcUserAuth->getIdentity()->getId();
            if ((int) $userId > 0) {
                $institution = $this->_institutionRepository->findBy(array(
                    'user' => $userId
                ));
                return count($institution) > 0 ? true : false;
            } else {
                return false;
            }
        }
        return false;
    }

    public function getInstitutionsHtml()
    {
        $checkboxElementFileParts = $this->getCheckboxElementHtml();
        
        $path = '/module/Admin/view/admin/institution/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        foreach ($this->findAllInstitutions() as $institution) {
            $count += 1;
            
            $isActive = (int) $institution->getIsActive() == 1 ? 'checked' : '';
            $toggleStatus = $checkboxElementFileParts[0] . $isActive . " id = 'institution-" . $institution->getId() . "-check-active-status'" . $checkboxElementFileParts[1];
            
            $dateEstablished = $institution->getDateEstablished() instanceof \DateTime ? $institution->getDateEstablished()->format('M d, Y') : '';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=institution-edit-" . $institution->getId() . ">Edit</option>
                            <option value=institution-delete-" . $institution->getId() . ">Delete</option>
                        </select>";
            $html .= "<tr><td>" . $count . "</td><td><a href = 'admin/institution/entry' class = 'link-to-edit-form' id = " . $institution->getId() . ">" . $institution->getInstName() . "</a></td><td>" . $institution->getInstAcronym() . "</td><td>" . $institution->getInstEmail() . "</td><td>" . $institution->getInstPhone() . "</td><td>" . $institution->getContactPerson() . "</td><td>" . $dateEstablished . "</td><td>" . $toggleStatus . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    public function updateActiveStatus($post)
    {
        $institutionRepository = $this->getInstitutionRepository();
        $entity = $institutionRepository->find($post['entity_id']);
        $entity->setIsActive($post['value']);
        return $institutionRepository->update($entity)->getId() ? true : false;
    }

    public function getPartners($userRoleId)
    {
        $partners = [];
        if ($userRoleId == 'root-admin') {
            $institutions = $this->findAllInstitutions();
            foreach ($institutions as $institution) {
                $partners[] = $institution->getUser();
            }
            
            return $partners;
        }
        
        return $partners;
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $institution = $this->findInstitution($entityId);
        return [
            [
                'id' => 'hidden',
                'value' => $institution->getId()
            ],
            [
                'id' => 'user',
                'value' => $institution->getUser()->getId()
            ],
            [
                'id' => 'instName',
                'value' => $institution->getInstName()
            ],
            [
                'id' => 'instDescription',
                'value' => $institution->getInstDescription()
            ],
            [
                'id' => 'instAcronym',
                'value' => $institution->getInstAcronym()
            ],
            [
                'id' => 'instEmail',
                'value' => $institution->getInstEmail()
            ],
            [
                'id' => 'instPhone',
                'value' => $institution->getInstPhone()
            ],
            [
                'id' => 'contactPerson',
                'value' => $institution->getContactPerson()
            ],
            [
                'id' => 'dateEstablished',
                'value' => $institution->getDateEstablished() instanceof \DateTime ? $institution->getDateEstablished()->format('Y-m-d') : ''
            ],
            [
                'id' => 'isActive',
                'value' => $institution->getIsActive()
            ]
        ];
    }
}