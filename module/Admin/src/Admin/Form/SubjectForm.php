<?php
namespace Admin\Form;

use Admin\Form\Fieldset\SubjectFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\SubjectRepositoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class SubjectForm extends Form
{

    public function __construct(SubjectRepositoryInterface $subjectRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('subject-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'subject-registration-form'
        ));
        
        // The form will hydrate an object of type "Subject"
        $this->setHydrator(new DoctrineHydrator($subjectRepository->getEntityManager()));
        
        // Add the user fieldset, and set it as the base fieldset
        $subjectFieldset = new SubjectFieldset($subjectRepository, $serviceLocator);
        $subjectFieldset->setUseAsBaseFieldset(true);
        $this->add($subjectFieldset);
        $this->add(new CommonFieldset());
    }
}