<?php
namespace Admin\Form\Academic;

use Admin\Form\Fieldset\Academic\DepartmentFieldset;
use Base\Form\Fieldset\CommonFieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Repository\Contract\Academic\DepartmentRepositoryInterface;
use Base\Form\Base as BaseForm;

class DepartmentForm extends BaseForm
{

    protected $_departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        parent::__construct('department-form');
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'department-registration-form'
        ));
        // The form will hydrate an object of type "Department"
        $this->setHydrator(new DoctrineHydrator($departmentRepository->getEntityManager()));
        
        // Add the user fieldset, and set it as the base fieldset
        $examFieldset = new DepartmentFieldset($departmentRepository);
        $examFieldset->setUseAsBaseFieldset(true);
        $this->add($examFieldset);
        $this->add(new CommonFieldset());
    }
}