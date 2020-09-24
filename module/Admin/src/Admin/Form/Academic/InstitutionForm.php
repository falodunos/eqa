<?php
namespace Admin\Form\Academic;

use Admin\Form\Fieldset\Academic\InstitutionFieldset;
use Base\Form\Fieldset\CommonFieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Repository\Contract\Academic\InstitutionRepositoryInterface;
use Base\Form\Base as BaseForm;

class InstitutionForm extends BaseForm
{

    protected $_instRepository;

    public function __construct(InstitutionRepositoryInterface $instRepository)
    {
        $this->_instRepository = $instRepository;
        parent::__construct('institution-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'institution-registration-form'
        ));
        // The form will hydrate an object of type "Institution"
        $this->setHydrator(new DoctrineHydrator($instRepository->getEntityManager()));
        
        // Add the user fieldset, and set it as the base fieldset
        $instFieldset = new InstitutionFieldset($instRepository);
        $instFieldset->setUseAsBaseFieldset(true);
        $this->add($instFieldset);
        $this->add(new CommonFieldset());
    }
}