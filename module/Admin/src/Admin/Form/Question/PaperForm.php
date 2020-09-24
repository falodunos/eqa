<?php
namespace Admin\Form\Question;

use Admin\Form\Fieldset\Question\PaperFieldset as QuestionPaperFieldset;
use Base\Form\Fieldset\CommonFieldset;
use Admin\Repository\Contract\Question\PaperRepositoryInterface as QuestionPaperRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;

class PaperForm extends BaseForm
{
    public function __construct(QuestionPaperRepositoryInterface $questionPaperRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('question-paper-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-question-paper-form'
        ));
        
        // The form will hydrate an object of type "Level"
        $this->setHydrator(new DoctrineHydrator($questionPaperRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $questionPaperFieldset = new QuestionPaperFieldset($questionPaperRepository, $serviceLocator);
        $questionPaperFieldset->setUseAsBaseFieldset(true);
        $this->add($questionPaperFieldset);
        $this->add(new CommonFieldset());
    }

   
}