<?php
namespace Application\Form\User;

use Zend\Form\Form;
use Base\Form\Fieldset\CommonFieldset;
use Application\Repository\Contract\UserRepositoryInterface;
use Application\Form\Fieldset\ProfileFieldset;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ProfileForm extends Form
{

    public function __construct(UserRepositoryInterface $userRepository, ServiceLocatorInterface $serviceLocator)
    {
        $this->_subject_repository = $userRepository;
        parent::__construct('profile-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'user-profile-form'
        ));
        
        // The form will hydrate an object of type "Exam"
        $this->setHydrator(new DoctrineHydrator($userRepository->getEntityManager()));
        
        // Add the user fieldset, and set it as the base fieldset
        $profileFieldset = new ProfileFieldset($userRepository, $serviceLocator);
        $profileFieldset->setUseAsBaseFieldset(true);
        $this->add($profileFieldset);
        
        $this->add(new CommonFieldset());
    }
}