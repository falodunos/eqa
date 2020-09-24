<?php
namespace Admin\Form\Question;

use Admin\Form\Fieldset\Question\TypeFieldset as QuestionTypeFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Question\TypeRepositoryInterface as QuestionTypeRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;

class TypeForm extends BaseForm
{
    public function __construct(QuestionTypeRepositoryInterface $questionTypeRepository)
    {
        parent::__construct('question-type-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-question-type-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($questionTypeRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $questionTypeFieldset = new QuestionTypeFieldset($questionTypeRepository);
        $questionTypeFieldset->setUseAsBaseFieldset(true);
        $this->add($questionTypeFieldset);
        $this->add(new CommonFieldset());
    }

   
}