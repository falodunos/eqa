<?php
namespace Application\EventManager\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
use Zend\Http;
class EventsListeners implements ListenerAggregateInterface
{

    /**
     *
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /*
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::detach()
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        // get shared event manager instance ...
        $sharedEvent = $events->getSharedManager();
        
        // add listeners for ZfcUser Register Form ...
        $this->listeners[] = $sharedEvent->attach('ZfcUser\Form\Register', 'init', array(
            $this,
            'addCustomFieldsToZfcRegisterForm'
        ), 100);
        $this->listeners[] = $sharedEvent->attach('ZfcUser\Form\RegisterFilter', 'init', array(
            $this,
            'addFilterAndValidationToZfcRegisterForm'
        ), 100);
        $this->listeners[] = $sharedEvent->attach('register', 'init', array(
            $this,
            'saveZfcUserRegisterFormCustomFields'
        ), 100);
        
        // add listeners and rememberMe checkbox to ZfcUser login form
        $this->listeners[] = $sharedEvent->attach('ZfcUser\Form\Login', 'init', array(
            $this,
            'addCustomFieldsToZfcLoginForm'
        ), 100);
        
        // add listeners to assign user role to newly registered user account
//         $this->listeners[] = $sharedEvent->attach('ZfcUser\Service\User', 'register.post', array(
//             $this,
//             'onRegisterPost'
//         ), 100);
    }
    
    public function addCustomFieldsToZfcRegisterForm($e)
    { /* @var $form \ZfcUser\Form\Register */
        $form = $e->getTarget();
        
        $form->add(array(
            'name' => 'firstName',
            'type' => 'text',
            'options' => array(
                'label' => 'First name'
            ),
            'attributes' => array(
                'id' => 'firstName'
            )
        ));
        
        $form->add(array(
            'name' => 'lastName',
            'type' => 'text',
            'options' => array(
                'label' => 'Last name'
            ),
            'attributes' => array(
                'id' => 'lastName'
            )
        ));
        $form->add(array(
            'name' => 'phoneNumber',
            'type' => 'text',
            'options' => array(
                'label' => 'Phone Number'
            ),
            'attributes' => array(
                'id' => 'phoneNumber'
            )
        ));
    }

    public function addFilterAndValidationToZfcRegisterForm($e)
    {
        /* @var $form \ZfcUser\Form\RegisterFilter */
        $filter = $e->getTarget();
        
        // Custom field firstname
        $filter->add(array(
            'name' => 'firstName',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255
                    )
                )
            )
        ));
        
        // Custom field lastname
        $filter->add(array(
            'name' => 'lastName',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255
                    )
                )
            )
        ));
        
        $filter->add(array(
            'name' => 'phoneNumber',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^\+?\d{11,12}$/'
                    )
                )
            )
        ));
    }

    public function saveZfcUserRegisterFormCustomFields($e)
    {
        $form = $e->getParam('form');
        $user = $e->getParam('user');
        /* @var $user \Application\Entity\User */
        $user->setFirstName($form->get('firstName')
            ->getValue());
        $user->setLastName($form->get('lastName')
            ->getValue());
        $user->setPhoneNumber($form->get('phoneNumber')
            ->getValue());
    }

    public function addCustomFieldsToZfcLoginForm($e)
    { /* @var $form \ZfcUser\Form\Login */
        $form = $e->getTarget();
        
        $form->add(array(
            'name' => 'rememberMe',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Remember me',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'value' => '0',
                'id' => 'rememberMe'
            )
        ));
    }

}