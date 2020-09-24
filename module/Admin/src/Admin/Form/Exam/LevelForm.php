<?php
namespace Admin\Form\Exam;

use Admin\Form\Fieldset\Exam\LevelFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Exam\LevelRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;

class LevelForm extends BaseForm
{
    public function __construct(LevelRepositoryInterface $levelRepository)
    {
        parent::__construct('level-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-level-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($levelRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $levelFieldset = new LevelFieldset($levelRepository);
        $levelFieldset->setUseAsBaseFieldset(true);
        $this->add($levelFieldset);
        $this->add(new CommonFieldset());
    }

   
}