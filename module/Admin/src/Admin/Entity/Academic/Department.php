<?php
namespace Admin\Entity\Academic;

use Base\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Contract\Academic\DepartmentInterface;
use Admin\Entity\Academic\Institution;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\Academic\DepartmentRepository")
 * @ORM\Table(name="departments")
 */
class Department extends AbstractBaseEntity implements DepartmentInterface
{

    /**
     * @ORM\Column(type="string", name="dept_name", nullable=false)
     */
    protected $deptName;

    /**
     * @ORM\Column(type="string", name="dept_description", nullable=false)
     */
    protected $deptDescription;

    /**
     * @ORM\Column(type="string", name="dept_acronym", nullable=false)
     */
    protected $deptAcronym;

    /**
     * @ORM\Column(type="datetime", name="date_established", nullable=false)
     */
    protected $dateEstablished;

    /**
     * @ORM\Column(type="string", name="contact_person", nullable=false)
     */
    protected $contactPerson;

    /**
     * @ORM\Column(type="string", name="dept_phone", nullable=false, unique = true)
     */
    protected $deptPhone;

    /**
     * @ORM\Column(type="string", name="dept_email", nullable=false)
     */
    protected $deptEmail;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Academic\Institution", inversedBy="departments")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="id")
     */
    protected $institution;

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\User", inversedBy="department")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\User\Identity", mappedBy="department")
     */
    protected $userIdentities;

    public function __construct()
    {
        $this->userIdentities = new ArrayCollection();
    }

    public function addUserIdentities(Collection $userIdentities)
    {
        foreach ($userIdentities as $userIdentity) {
            $userIdentity->setDepartment($this);
            $this->userIdentities->add($userIdentity);
        }
    }

    public function removeUserIdentities(Collection $userIdentities)
    {
        foreach ($userIdentities as $userIdentity) {
            $userIdentity->setDepartment(null);
            $this->userIdentities->remove($userIdentity);
        }
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     *
     * @param field_type $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    
    
    /**
     *
     * @return the $userIdentities
     */
    public function getUserIdentities()
    {
        return $this->userIdentities;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getInstitution()
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setInstitution()
     */
    public function setInstitution(Institution $institution = null)
    {
        $this->institution = $institution;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDeptName()
     */
    public function getDeptName()
    {
        return $this->deptName;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setDeptName()
     */
    public function setDeptName($deptName)
    {
        $this->deptName = $deptName;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDeptAcronym()
     */
    public function getDeptAcronym()
    {
        return $this->deptAcronym;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setDeptAcronym()
     */
    public function setDeptAcronym($deptAcronym)
    {
        $this->deptAcronym = $deptAcronym;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDeptDescription()
     */
    public function getDeptDescription()
    {
        return $this->deptDescription;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setInstDescription()
     */
    public function setDeptDescription($deptDescription)
    {
        $this->deptDescription = $deptDescription;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDateEstablished()
     */
    public function getDateEstablished()
    {
        return $this->dateEstablished;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setDateEstablished()
     */
    public function setDateEstablished($dateEstablished)
    {
        $this->dateEstablished = $dateEstablished;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setContactPerson()
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getContactPerson()
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setDeptPhone()
     */
    public function setDeptPhone($deptPhone)
    {
        $this->deptPhone = $deptPhone;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDeptPhone()
     */
    public function getDeptPhone()
    {
        return $this->deptPhone;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::setDeptEmail()
     */
    public function setDeptEmail($deptEmail)
    {
        $this->deptEmail = $deptEmail;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\DepartmentInterface::getDeptEmail()
     */
    public function getDeptEmail()
    {
        return $this->deptEmail;
    }
}