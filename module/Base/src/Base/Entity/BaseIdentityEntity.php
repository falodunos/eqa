<?php
namespace Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\Contract\BaseIdentityInterface;
use Base\Entity\AbstractBaseEntity;
use Admin\Entity\Academic\Department;
use Admin\Entity\Academic\Institution;

/*
 * @ORM\MappedSuperclass
 */
class BaseIdentityEntity extends AbstractBaseEntity implements BaseIdentityInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Academic\Institution")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="id")
     */
    protected $institution;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Academic\Department")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    protected $department;
    
	/**
     * @return the $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

	/**
     * @return the $department
     */
    public function getDepartment()
    {
        return $this->department;
    }

	/**
     * @param field_type $institution
     */
    public function setInstitution(Institution $institution)
    {
        $this->institution = $institution;
        return $this;
    }

	/**
     * @param field_type $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
        return $this;
    }

}