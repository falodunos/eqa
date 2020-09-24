<?php
namespace Admin\Form\Question;

use Admin\Form\Fieldset\Question\SectionFieldset as QuestionSectionFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Question\SectionRepositoryInterface as QuestionSectionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionForm extends BaseForm
{

    public function __construct(QuestionSectionRepositoryInterface $questionSectionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-section-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-question-section-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($questionSectionRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $questionSectionFieldset = new QuestionSectionFieldset($questionSectionRepository, $serviceLocator);
        $questionSectionFieldset->setUseAsBaseFieldset(true);
        $this->add($questionSectionFieldset);
        $this->add(new CommonFieldset());
    }
}