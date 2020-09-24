<?php
namespace Admin\Form\Answer;

use Admin\Form\Fieldset\Answer\OptionFieldset as AnswerOptionFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Answer\OptionRepositoryInterface as AnswerOptionRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionForm extends BaseForm
{

    public function __construct(AnswerOptionRepositoryInterface $answerOptionRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('exam-answer-option-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-answer-option-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($answerOptionRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $answerOptionFieldset = new AnswerOptionFieldset($answerOptionRepository, $serviceLocator);
        $answerOptionFieldset->setUseAsBaseFieldset(true);
        $this->add($answerOptionFieldset);
        $this->add(new CommonFieldset());
    }
}