<?php
namespace Base\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CommonFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct()
    {
        parent::__construct('common-fieldset');
        
        $this
//         ->add(array(
//             'type' => 'Zend\Form\Element\Csrf',
//             'name' => 'csrf',
//             'options' => array(
//                 'label' => 'Security Code'
//             )
//         ))
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
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'clear',
            'options' => array(
                'label' => 'Submit'
            ),
            'attributes' => array(
                'value' => 'Clear Form',
                'class' => 'btn btn-success',
                'id' => 'clear-btn'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'csrf' => array(
                'required' => false
            )
        );
    }
}