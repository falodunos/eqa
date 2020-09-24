<?php
namespace Admin\Form\Question;

use Admin\Entity\Question\Image as QuestionImage;
use Admin\Form\Fieldset\Question\ImageFieldset as QuestionImageFieldset;
use Admin\Repository\Contract\Question\ImageRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter;

class ImageForm extends BaseForm
{

    public function __construct(ImageRepositoryInterface $questionImageRepository)
    {
        parent::__construct('document-upload-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'document-upload-form',
            'method' => 'post'
        ));
        
        $this->setHydrator(new DoctrineHydrator($questionImageRepository->getEntityManager()))
            ->setInputFilter(new InputFilter\InputFilter());
        
        // Add the user fieldset, and set it as the base fieldset
        $questionImageFieldset = new QuestionImageFieldset($questionImageRepository, new QuestionImage());
        $questionImageFieldset->setUseAsBaseFieldset(true);
        $this->add($questionImageFieldset);
    }

}