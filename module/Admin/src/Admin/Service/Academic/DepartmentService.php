<?php
namespace Admin\Service\Academic;

use Admin\Service\Contract\Academic\DepartmentServiceInterface;
use Admin\Repository\Academic\DepartmentRepository;
use Base\Service\BaseService;
use Admin\Entity\Academic\Department;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Contract\Academic\DepartmentInterface;

class DepartmentService extends BaseService implements DepartmentServiceInterface
{

    protected $_departmentRepository;

    protected $_departmentEntity;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setDepartmentRepository($this->getServiceLocator()
            ->get('examsqa_admin_department_repository'));
        
        if (is_null($this->_departmentEntity)) {
            $this->_departmentEntity = new Department();
        }
    }

    protected function _setDepartmentRepository(DepartmentRepository $examsqa_department_repository)
    {
        $this->_departmentRepository = $examsqa_department_repository;
    }

    public function getDepartmentRepository()
    {
        return $this->_departmentRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\DepartmentServiceInterface::findDepartment()
     */
    public function findDepartment($id)
    {
        return $this->getDepartmentRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\DepartmentServiceInterface::deleteDepartment()
     */
    public function deleteDepartment(DepartmentInterface $department)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\DepartmentServiceInterface::findDepartments()
     */
    public function findDepartments($criteria)
    {
        return $this->getDepartmentRepository()->findBy($criteria);
    }

    public function getDepartmentFromAuthService()
    {
        if ($this->getZfcUserIdentity()
            ->getRoles()[0]
            ->getRoleId() == 'operation-admin') {
            return $this->getZfcUserIdentity()
                ->getIdentity()
                ->getDepartment();
        }
        
        return null;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\DepartmentServiceInterface::findDepartmentBy()
     */
    public function findDepartmentBy(array $criteria)
    {
        return $this->getDepartmentRepository()->findBy($criteria);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Academic\DepartmentServiceInterface::findDepartments()
     */
    public function findAllDepartments()
    {
        return $this->getDepartmentRepository()->findAll();
    }

    public function saveDepartment($post)
    {
        // this action will perform both create and update operation on Department object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_department_form'); // Create the exam form
        $department_repository = $this->getDepartmentRepository();
        $dateTime = new \DateTime("now");
        $id = $post['department-fieldset']['id'];
        
        if ($id) { // updating existing QeustionType entity ...
            $department_repository->setEntityClass($this->_departmentEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                
                if ($this->getAdminRoleId() == 'super-admin') {
                    $entity->setInstitution($this->getZfcUserIdentity()
                        ->getInstitution());
                }
                return $department_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new question type entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                return $department_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    public function getInstitution($userId)
    {
        $instService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        $institution = $instService->getInstitution($userId);
        return count($institution) == 1 ? $institution[0] : null;
    }

    public function getDepartmentsHtml()
    {
        $path = '/module/Admin/view/admin/department/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        $institution = $this->getZfcUserIdentity()->getInstitution();
        
        if (! is_null($institution)) {
            foreach ($this->findDepartmentBy(array(
                'institution' => $institution
            )) as $department) {
                $count += 1;
                $status = (int) $department->getIsActive() == 1 ? 'Active' : 'In-active';
                
                $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=department-edit-" . $department->getId() . ">Edit</option>
                            <option value=department-delete-" . $department->getId() . ">Delete</option>
                        </select>";
                
                $dateEstablished = $department->getDateEstablished() instanceof \DateTime ? $department->getDateEstablished()->format('M d, Y') : '';
                $html .= "<tr><td>" . $count . "</td><td><a href = 'admin/department/entry' class = 'link-to-edit-form' id = " . $department->getId() . ">" . $department->getDeptName() . "</a></td><td>" . $department->getInstitution()->getInstAcronym() . "</a></td><td>" . $department->getDeptAcronym() . "</td><td>" . $department->getDeptEmail() . "</td><td>" . $department->getDeptPhone() . "</td><td>" . $department->getContactPerson() . "</td><td>" . $dateEstablished . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
            }
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $department = $this->findDepartment($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $department->getId()
            ],
            [
                'id' => 'deptName',
                'value' => $department->getDeptName()
            ],
            [
                'id' => 'deptAcronym',
                'value' => $department->getDeptAcronym()
            ],
            [
                'id' => 'deptDescription',
                'value' => $department->getDeptDescription()
            ],
            [
                'id' => 'deptEmail',
                'value' => $department->getDeptEmail()
            ],
            [
                'id' => 'deptPhone',
                'value' => $department->getDeptPhone()
            ],
            [
                'id' => 'contactPerson',
                'value' => $department->getContactPerson()
            ],
            [
                'id' => 'dateEstablished',
                'value' => $department->getDateEstablished() instanceof \DateTime ? $department->getDateEstablished()->format('Y-m-d') : ''
            ],
            [
                'id' => 'isActive',
                'value' => $department->getIsActive()
            ]
        );
    }
}