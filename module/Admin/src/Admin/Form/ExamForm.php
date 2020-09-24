<?php
namespace Admin\Form;

use Admin\Form\Fieldset\ExamFieldset;
use Base\Form\Fieldset\CommonFieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Repository\Contract\SubjectRepositoryInterface;
use Admin\Repository\Contract\ExamRepositoryInterface;
use Base\Form\Base as BaseForm;
use Zend\ServiceManager\ServiceLocatorInterface;
class ExamForm extends BaseForm
{

    public function __construct(ExamRepositoryInterface $examRepository, SubjectRepositoryInterface $subjectRepository, ServiceLocatorInterface $serviceLocator)
    {
        $this->_subject_repository = $subjectRepository;
        parent::__construct('exam-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-registration-form'
        ));
        // The form will hydrate an object of type "Exam"
        $this->setHydrator(new DoctrineHydrator($examRepository->getEntityManager()));
        
        // Add the user fieldset, and set it as the base fieldset
        $examFieldset = new ExamFieldset($examRepository, $subjectRepository, $serviceLocator);
        $examFieldset->setUseAsBaseFieldset(true);
        $this->add($examFieldset);
        $this->add(new CommonFieldset());
    }
}