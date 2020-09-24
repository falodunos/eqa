<?php
namespace Admin\Service\Question;

use Admin\Service\Contract\Question\SectionServiceInterface as QuestionSectionServiceInterface;
use Admin\Repository\Question\SectionRepository as QuestionSectionRepository;
use Base\Service\BaseService;
use Admin\Entity\Question\Section as QuestionSection;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionService extends BaseService implements QuestionSectionServiceInterface
{

    protected $_questionSectionRepository;

    protected $_questionSectionEntity;

    protected $_institutionService;

    protected $_questionTypeEntity;

    protected $_departmentService;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setQuestionSectionRepository($this->getServiceLocator()
            ->get('examsqa_admin_question_section_repository'));
        
        $this->_departmentService = $this->getServiceLocator()->get('examsqa_admin_department_service');
        $this->_institutionService = $this->getServiceLocator()->get('examsqa_admin_institution_service');
        
        if (is_null($this->_questionSectionEntity)) {
            $this->_questionSectionEntity = new QuestionSection();
        }
    }

    protected function _setQuestionSectionRepository(QuestionSectionRepository $examsqa_question_section_repository)
    {
        $this->_questionSectionRepository = $examsqa_question_section_repository;
    }

    public function getQuestionSectionRepository()
    {
        return $this->_questionSectionRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\SectionServiceInterface::findQuestionSection()
     */
    public function findQuestionSection($id)
    {
        return $this->getQuestionSectionRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\SectionServiceInterface::deleteQuestionSection()
     */
    public function deleteQuestionSection(\Admin\Entity\Contract\Question\SectionInterface $questionSection)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\SectionServiceInterface::findAllQuestionPapers()
     */
    public function findAllQuestionSections()
    {
        return $this->getQuestionSectionRepository()->findAll();
    }

    public function saveQuestionSection($post)
    {
        // this action will perform both create and update operation on QuestionSection object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_question_section_form'); // Create the exam form
        $question_section_repository = $this->getQuestionSectionRepository();
        $dateTime = new \DateTime("now");
        $id = $post['question-section-fieldset']['id'];
        
        if ($id) { // updating existing QeustionSection entity ...
            $question_section_repository->setEntityClass($this->_questionSectionEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $question_section_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new question paper entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                
                $entity->setInstitution($this->_institutionService->getInstitutionFromAuthService())
                    ->setCreatedAt($dateTime)
                    ->setUpdatedAt($dateTime);
                
                $department = $this->_departmentService->getDepartmentFromAuthService();
                ! is_null($department) ? $entity->setDepartment($department) : '';
                
                return $question_section_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    public function getQuestionSectionsHtml()
    {
        $path = '/module/Admin/view/admin/question-section/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        foreach ($this->findQuestionSectionBy($this->getInstitutionDepartmentSelectFilterCriteria()) as $questionSection) {
            $count += 1;
            $status = (int) $questionSection->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = "<select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=question_section-edit-" . $questionSection->getId() . ">Edit</option>
                            <option value=question_section-delete-" . $questionSection->getId() . ">Delete</option>
                        </select>";
            
            $institution = $this->_institutionService->findInstitution($questionSection->getInstitution()
                ->getId())
                ->getInstName();
            $department = $this->_departmentService->findDepartment($questionSection->getDepartment()
                ->getId())
                ->getDeptName();
            
            $html .= "<tr><td>" . $count . "</td><td>" . $questionSection->getSectionName() . "</td><td>" . $questionSection->getSectionDescription() . "</td><td>" . $questionSection->getSectionInfo() . "</td><td>" . $questionSection->getSectionPaper()->getPaperName() . "</td><td>" . $institution . "</td><td>" . $department . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    
    /* (non-PHPdoc)
     * @see \Admin\Service\Contract\Question\SectionServiceInterface::findQuestionSectionBy()
     */
    public function findQuestionSectionBy($criteria)
    {
        return $this->getQuestionSectionRepository()->findBy($criteria);
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $questionSection = $this->findQuestionSection($entityId);
        // var_dump($questionSection->getQuestionPaper()->getId()); die;
        return array(
            [
                'id' => 'hidden',
                'value' => $questionSection->getId()
            ],
            [
                'id' => 'sectionInfo',
                'value' => $questionSection->getSectionInfo()
            ],
            [
                'id' => 'sectionName',
                'value' => $questionSection->getSectionName()
            ],
            [
                'id' => 'sectionDescription',
                'value' => $questionSection->getSectionDescription()
            ],
            [
                'id' => 'sectionPaper',
                'value' => $questionSection->getSectionPaper()->getId()
            ],
            [
                'id' => 'isActive',
                'value' => $questionSection->getIsActive()
            ]
        );
    }

    protected function getYearOptionValues($yearId)
    {
        $options = array(
            '' => '- Select Year -'
        );
        $currentYear = date('Y');
        $minYear = 1980;
        $Kount = 1;
        for ($i = $minYear; $i <= $currentYear; $i ++) {
            $options[$Kount] = $i;
            ++ $Kount;
        }
        return $options[$yearId];
    }

    public function loadPaperSections($paperId = null)
    {
        $repository = $this->getQuestionSectionRepository();
        return $repository->loadPaperSections($paperId);
    }
}