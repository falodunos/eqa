<?php
namespace Admin\Service\Exam;

use Admin\Service\Contract\Exam\LevelServiceInterface;
use Admin\Entity\Contract\Exam\LevelInterface;
use Admin\Repository\Exam\LevelRepository;
use Base\Service\BaseService;
use Admin\Entity\Exam\Level;
use Zend\ServiceManager\ServiceLocatorInterface;

class LevelService extends BaseService implements LevelServiceInterface
{

    protected $_level_repository;

    protected $_levelEntity;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
        $this->_setLevelRepository($this->getServiceLocator()
            ->get('examsqa_admin_level_repository'));
        
        if (is_null($this->_levelEntity)) {
            $this->_levelEntity = new Level();
        }
    }

    protected function _setLevelRepository(LevelRepository $examsqa_level_repository)
    {
        $this->_level_repository = $examsqa_level_repository;
    }

    public function getLevelRepository()
    {
        return $this->_level_repository;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\ExamServiceInterface::saveExam()
     */
    public function saveLevel($post)
    {
        // this action will perform both create and update operation on Exam object ...
        $form = $this->getServiceLocator()->get('examsqa_admin_level_form'); // Create the exam form
        $level_repository = $this->getLevelRepository();
        $dateTime = new \DateTime("now");
        $id = $post['level-fieldset']['id'];
        
        if ($id) { // updating existing level entity ...
            $level_repository->setEntityClass($this->_levelEntity);
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setUpdatedAt($dateTime);
                return $level_repository->update($entity)->getId() ? true : false; // save modified entity
            }
        } else { // creating new level entity
            $form->setData($post);
            if ($form->isValid()) {
                $entity = $form->getData();
                $entity->setCreatedAt($dateTime)->setUpdatedAt($dateTime);
                
                if($this->getAdminRoleId() == 'super-admin'){
                    $entity->setInstitution($this->getZfcUserIdentity()->getInstitution());
                }
                return $level_repository->insert($entity)->getId() ? true : false;
            } else {
                /*
                 * var_dump($form->getMessages());
                 */
            }
        }
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\LevelServiceInterface::findLevel()
     */
    public function findLevel($id)
    {
        return $this->getLevelRepository()->findById($id);
    }

    public function findLevelBy(array $criteria){
        return $this->getLevelRepository()->findBy($criteria);
    }
    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\LevelServiceInterface::deleteLevel()
     */
    public function deleteLevel(LevelInterface $exam)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Service\Contract\LevelServiceInterface::findAllLevels()
     */
    public function findAllLevels()
    {
        return $this->getLevelRepository()->findAll();
    }

    public function getExamLevelsHtml()
    {
        $path = '/module/Admin/view/admin/level/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        $institution = $this->getZfcUserIdentity()->getInstitution();
        foreach ($this->findLevelBy(array('institution' => $institution)) as $level) {
            $count += 1;
            $status = (int) $level->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=level-edit-" . $level->getId() . ">Edit</option>
                            <option value=level-delete-" . $level->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $level->getLevelName() . "</td><td>" . $level->getLevelCode() . "</td><td>" . $level->getLevelDescription() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        $level = $this->findLevel($entityId);
        return array(
            [
                'id' => 'hidden',
                'value' => $level->getId()
            ],
            [
                'id' => 'levelName',
                'value' => $level->getLevelName()
            ],
            [
                'id' => 'levelCode',
                'value' => $level->getLevelCode()
            ],
            [
                'id' => 'levelDescription',
                'value' => $level->getLevelDescription()
            ],
            [
                'id' => 'isActive',
                'value' => $level->getIsActive()
            ]
        );
    }
}