<?php
namespace Admin\Service\Question;

use Admin\Service\Contract\Question\TypeServiceInterface as QuestionTypeServiceInterface;
use Admin\Repository\Question\TypeRepository as QuestionTypeRepository;
use Base\Service\BaseService;
use Admin\Entity\Question\Type as QuestionType;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Entity\Contract\Question\TypeInterface as QuestionTypeInterface;

class TypeService extends BaseService implements QuestionTypeServiceInterface
{

    protected $_questionTypeRepository;

    protected $_departmentService;

    protected $_institutionService;

    protected $_questionTypeEntity;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setQuestionTypeRepository($this->getServiceLocator()
            ->get('examsqa_admin_question_type_repository'));
        
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        
        if (is_null($this->_questionTypeEntity)) {
            $this->_questionTypeEntity = new QuestionType();
        }
    }

    protected function _setQuestionTypeRepository(QuestionTypeRepository $examsqa_question_type_repository)
    {
        $this->_questionTypeRepository = $examsqa_question_type_repository;
    }

    public function getQuestionTypeRepository()
    {
        return $this->_questionTypeRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\TypeServiceInterface::findQuestionType()
     */
    public function findQuestionType($id)
    {
        return $this->getQuestionTypeRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\TypeServiceInterface::deleteQuestionType()
     */
    public function deleteQuestionType(QuestionTypeInterface $questionType)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\TypeServiceInterface::findAllQuestionPapers()
     */
    public function findAllQuestionTypes()
    {
        return $this->getQuestionTypeRepository()->findAll();
    }

    public function saveQuestionType($post)
    {
        // this action will perform both create and update operation on QuestionType object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_question_type_form'); // Create the exam form
        $question_type_repository = $this->getQuestionTypeRepository();
        $dateTime = new \DateTime("now");
        $id = $post['question-type-fieldset']['id'];
//         $institution = $this->_institutionService->findInstitution(1);
//         $department = $this->_departmentService->findDepartment(1);
        
        if ($id) { // updating existing QeustionType entity ...
            $question_type_repository->setEntityClass($this->_questionTypeEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
//                 $entity->setInstitution($institution)->setDepartment($department);
                $entity->setUpdatedAt($dateTime);
                return $question_type_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new question type entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
//                 $entity->setInstitution($institution)->setDepartment($department);
                $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                return $question_type_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    public function getQuestionTypesHtml()
    {
        $path = '/module/Admin/view/admin/question-type/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        foreach ($this->findAllQuestionTypes() as $questionType) {
            $count += 1;
            $status = (int) $questionType->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=question_type-edit-" . $questionType->getId() . ">Edit</option>
                            <option value=question_type-delete-" . $questionType->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $questionType->getTypeName() . "</a></td><td>" . $questionType->getTypeDescription() .  "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $questionType = $this->findQuestionType($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $questionType->getId()
            ],
            [
                'id' => 'typeName',
                'value' => $questionType->getTypeName()
            ],
            [
                'id' => 'typeDescription',
                'value' => $questionType->getTypeDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $questionType->getIsActive()
            ]
        );
    }
}