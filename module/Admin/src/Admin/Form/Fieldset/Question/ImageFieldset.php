<?php
namespace Admin\Form\Fieldset\Question;

use Base\Form\Fieldset\Common\DocumentFieldset as CommonDocumentFieldset;
use Admin\Entity\Question\Image as QuestionImageEntity;
use Admin\Repository\Contract\Question\ImageRepositoryInterface as QuestionImageRepositoryInterface;
// use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ImageFieldset extends CommonDocumentFieldset
{

    protected $_entityManager = null;

    public function __construct(QuestionImageRepositoryInterface $entityRepository, QuestionImageEntity $entityInstance)
    {
        parent::__construct($entityRepository, $entityInstance);
    }
}