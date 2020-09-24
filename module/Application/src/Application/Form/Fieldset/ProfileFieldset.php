<?php
namespace Application\Form\Fieldset;

use Application\Entity\User as UserEntity;
use Application\Repository\Contract\UserRepositoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $_entityManager = null;

    public function __construct(UserRepositoryInterface $userRepository, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct('user-profile-fieldset');
        
        $user = new UserEntity();
        $this->_entityManager = $userRepository->getEntityManager();
        $this->setHydrator(new DoctrineHydrator($this->_entityManager))->setObject($user);

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'id' => 'hidden',
            ),
        ))->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'firstName',
            'attributes' => array(
                'id' => 'firstName',
                'class' => 'form-control',
                'placeholder' => 'First Name'
            ),
            'options' => array(
                'label' => 'First Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'lastName',
            'attributes' => array(
                'id' => 'lastName',
                'class' => 'form-control',
                'placeholder' => 'Last Name'
            ),
            'options' => array(
                'label' => 'Last Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'attributes' => array(
                'id' => 'username',
                'class' => 'form-control',
                'placeholder' => 'Username'
            ),
            'options' => array(
                'label' => 'Username'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'display_name',
            'attributes' => array(
                'id' => 'display_name',
                'class' => 'form-control',
                'placeholder' => 'Display Name'
            ),
            'options' => array(
                'label' => 'Display Name'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'phoneNumber',
            'attributes' => array(
                'id' => 'phoneNumber',
                'class' => 'form-control',
                'placeholder' => 'Phone Number'
            ),
            'options' => array(
                'label' => 'Phone Number'
            )
        ))
            ->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => array(
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Email'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'firstName' => array(
                'required' => true
            ),
            'lastName' => array(
                'required' => true
            ),
            'username' => array(
                'required' => false
            ),
            'display_name' => array(
                'required' => false
            ),
            'phoneNumber' => array(
                'required' => true
            ),
            'email' => array(
                'required' => true
            )
        );
    }
}