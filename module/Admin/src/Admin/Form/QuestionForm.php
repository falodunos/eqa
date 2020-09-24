<?php
namespace Admin\Form;

use Admin\Form\Fieldset\QuestionFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\QuestionRepositoryInterface as QuestionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;

class QuestionForm extends BaseForm
{
    public function __construct(QuestionRepositoryInterface $questionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-question-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($questionRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $questionFieldset = new QuestionFieldset($questionRepository, $serviceLocator);
        $questionFieldset->setUseAsBaseFieldset(true);
        $this->add($questionFieldset);
        $this->add(new CommonFieldset());
    }

   
}