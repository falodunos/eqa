<?php
namespace Application\Form\Question;

use Application\Repository\Contract\Question\CommentRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;
use Zend\InputFilter\InputFilter;

class CommentForm extends BaseForm
{

    public function __construct(CommentRepositoryInterface $questionCommentRepository)
    {
        parent::__construct('question-comment-form');
        
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-question-comment-form'
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'questionComment',
            'attributes' => array(
                'id' => 'questionComment',
                'class' => 'form-control',
                'placeholder' => 'Your commnts'
            ),
            'options' => array(
                'label' => 'Comment'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'options' => array(
                'label' => 'Submit'
            ),
            'attributes' => array(
                'value' => 'Save',
                'class' => 'btn btn-success',
                'id' => 'submit-btn'
            )
        ));
        // The form will hydrate an object of type "Comment"
        $this->setHydrator(new DoctrineHydrator($questionCommentRepository->getEntityManager()))
            ->setInputFilter(new InputFilter());
    }
}