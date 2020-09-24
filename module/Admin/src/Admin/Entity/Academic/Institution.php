<?php
namespace Admin\Entity\Academic;

use Base\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Admin\Entity\Contract\Academic\InstitutionInterface;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\Academic\InstitutionRepository")
 * @ORM\Table(name="institutions")
 */
class Institution extends AbstractBaseEntity implements InstitutionInterface
{

    /**
     * @ORM\Column(type="string", name="inst_name", nullable=false)
     */
    protected $instName;

    /**
     * @ORM\Column(type="string", name="inst_description", nullable=false)
     */
    protected $instDescription;

    /**
     * @ORM\Column(type="string", name="inst_acronym", nullable=false)
     */
    protected $instAcronym;

    /**
     * @ORM\Column(type="datetime", name="date_established", nullable=false)
     */
    protected $dateEstablished;

    /**
     * @ORM\Column(type="string", name="contact_person", nullable=false)
     */
    protected $contactPerson;

    /**
     * @ORM\Column(type="string", name="inst_phone", nullable=false, unique=true)
     */
    protected $instPhone;

    /**
     * @ORM\Column(type="string", name="inst_email", nullable=false)
     */
    protected $instEmail;

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\User", inversedBy="institution")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Academic\Department", mappedBy="institution")
     */
    protected $departments;
    
    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\User\Identity", mappedBy="institution")
     */
    protected $userIdentities;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->userIdentities = new ArrayCollection();
    }

    public function addDepartments(Collection $departments)
    {
        foreach ($departments as $department) {
            $department->setInstitution($this);
            $this->departments->add($department);
        }
    }

    public function removeDepartments(Collection $departments)
    {
        foreach ($departments as $department) {
            $department->setInstitution(null);
            $this->departments->remove($department);
        }
    }
    
    public function addUserIdentities(Collection $userIdentities)
    {
        foreach ($userIdentities as $userIdentity) {
            $userIdentity->setInstitution($this);
            $this->userIdentities->add($userIdentity);
        }
    }
    
    public function removeUserIdentities(Collection $userIdentities)
    {
        foreach ($userIdentities as $userIdentity) {
            $userIdentity->setInstitution(null);
            $this->userIdentities->remove($userIdentity);
        }
    }

    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * @return the $userIdentities
     */
    public function getUserIdentities()
    {
        return $this->userIdentities;
    }

 /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getInstName()
     */
    public function getInstName()
    {
        return $this->instName;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setInstName()
     */
    public function setInstName($instName)
    {
        $this->instName = $instName;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getInstAcronym()
     */
    public function getInstAcronym()
    {
        return $this->instAcronym;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setInstAcronym()
     */
    public function setInstAcronym($instAcronym)
    {
        $this->instAcronym = $instAcronym;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\Academic\InstitutionInterface::getInstDescription()
     */
    public function getInstDescription()
    {
        return $this->instDescription;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setInstDescription()
     */
    public function setInstDescription($instDescription)
    {
        $this->instDescription = $instDescription;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getDateEstablished()
     */
    public function getDateEstablished()
    {
        return $this->dateEstablished;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setDateEstablished()
     */
    public function setDateEstablished($dateEstablished)
    {
        $this->dateEstablished = $dateEstablished;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setContactPerson()
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getContactPerson()
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setInstPhone()
     */
    public function setInstPhone($instPhone)
    {
        $this->instPhone = $instPhone;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getInstPhone()
     */
    public function getInstPhone()
    {
        return $this->instPhone;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setInstEmail()
     */
    public function setInstEmail($instEmail)
    {
        $this->instEmail = $instEmail;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getInstEmail()
     */
    public function getInstEmail()
    {
        return $this->instEmail;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Academic\InstitutionInterface::setUser()
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}