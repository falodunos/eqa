<?php
namespace Admin\Service\Exam;

use Admin\Service\Contract\Exam\MonthServiceInterface as ExamMonthServiceInterface;
use Admin\Entity\Contract\Exam\MonthInterface;
use Admin\Repository\Exam\MonthRepository as ExamMonthRepository;
use Base\Service\BaseService;
use Admin\Entity\Exam\Month;
use Zend\ServiceManager\ServiceLocatorInterface;

class MonthService extends BaseService implements ExamMonthServiceInterface
{

    protected $_examMonthService;

    protected $_examMonthRepository;

    protected $_examMonthEntity;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setExamMonthRepository($this->getServiceLocator()
            ->get('examsqa_admin_exam_month_repository'));
        
        if (is_null($this->_examMonthEntity)) {
            $this->_examMonthEntity = new Month();
        }
    }

    protected function _setExamMonthRepository(ExamMonthRepository $examsqa_exam_month_repository)
    {
        $this->_examMonthRepository = $examsqa_exam_month_repository;
    }

    public function getExamMonthRepository()
    {
        return $this->_examMonthRepository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::saveExamMonth()
     */
    public function saveExamMonth($post)
    {
        // this action will perform both create and update operation on Exam object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_exam_month_form'); // Create the exam form
        $monthRepository = $this->getExamMonthRepository();
        $dateTime = new \DateTime("now");
        $id = $post['id'];
        
        if ($id) { // updating existing level entity ...
            $monthRepository->setEntityClass($this->_examMonthEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $monthRepository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new level entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                return $monthRepository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    public function getExamMonthsHtml()
    {
        $path = '/module/Admin/view/admin/exam-month/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        foreach ($this->findAllExamMonths() as $month) { //
            $count += 1;
            $status = (int) $month->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=exam_month-edit-" . $month->getId() . ">Edit</option>
                            <option value=exam_month-delete-" . $month->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr id = exam_month-" . $month->getId() . "><td>" . $count . "</td><td>" . $month->getExamMonth() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $month = $this->findExamMonth($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $month->getId()
            ],
            [
                'id' => 'examMonth',
                'value' => $month->getExamMonth()
            ],
            [
                'id' => 'isActive',
                'value' => $month->getIsActive()
            ]
        );
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamMonthServiceInterface::findExamMonth()
     */
    public function findExamMonth($id)
    {
        return $this->getExamMonthRepository()->findById($id);
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamMonthServiceInterface::deleteExam()
     */
    public function deleteExam(MonthInterface $examMonth)
    {}

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamMonthServiceInterface::findAllExamMonths()
     */
    public function findAllExamMonths()
    {
        return $this->getExamMonthRepository()->findAll();
    }
}