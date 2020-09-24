<?php
namespace Application\Entity;

use Application\Entity\Contract\UserInterface;
use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// use ZfcUser\Entity\User as zfcUserEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of User
 *
 * @author Solomon
 *          @ORM\Entity(repositoryClass="Application\Repository\UserRepository")
 *         @ORM\Table(name="users")
 */
class User implements UserInterface, ProviderInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="user_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="first_name", length=50, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", name="last_name", length=50, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", name="phone_number", length=20, unique=true, nullable=true)
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string", unique=true, length=50, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", name="display_name", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @ORM\Column(type="text", length=128)
     */
    protected $password;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $state;
    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     */
    protected $updatedAt;
    
    /**
     * @ORM\Column(type="string", name="is_active", length=1, nullable=false, options={"default":"1"})
     */
    protected $isActive;
    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Application\Entity\Role")
     *      @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    protected $roles;

    /**
     * @ORM\OneToOne(targetEntity="Admin\Entity\Academic\Institution", mappedBy="user")
     */
    protected $institution;
    
    /**
     * @ORM\OneToOne(targetEntity="Admin\Entity\Academic\Department", mappedBy="user")
     */
    protected $department;

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\User\Identity", mappedBy="user")
     */
    protected $identity;

    /**
     * @ORM\Column(type="string", name="is_admin", length=1, nullable=true, options={"default":"0"})
     */
    protected $isAdmin;

 /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $isAdmin
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    
    /**
     * @param field_type $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
    
    /**
     *
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $email            
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::getLastName()
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::setLastName()
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::getFirstName()
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::setFirstName()
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::getPhoneNumber()
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Application\Entity\Contract\UserInterface::setPhoneNumber()
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = (string) $phoneNumber;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::getUsername()
     */
    public function getUsername()
    {
        return $this->username;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::setUsername()
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::getDisplayName()
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::setDisplayName()
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::getPassword()
     */
    public function getPassword()
    {
        return $this->password;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::setPassword()
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::getState()
     */
    public function getState()
    {
        return $this->state;
    }

    /*
     * (non-PHPdoc)
     * @see \ZfcUser\Entity\UserInterface::setState()
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role            
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * Remove a role from the user.
     *
     * @param Role $role            
     */
    public function removeRole($role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Add roles to the user.
     *
     * @param Collection $roles            
     */
    public function addRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->add($role);
        }
    }

    /**
     * Remove roles from the user.
     *
     * @param Collection $roles            
     */
    public function removeRoles($roles)
    {
        foreach ($roles as $role) {
            $this->roles->removeElement($role);
        }
    }

    /**
     *
     * @return the $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     *
     * @param field_type $institution            
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
        return $this;
    }
    
    /**
     *
     * @return the $department
     */
    public function getDepartment()
    {
        return $this->department;
    }
    
    /**
     *
     * @param field_type $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     *
     * @return the $identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     *
     * @param field_type $identity            
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }
    /**
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @param \DateTime $updatedAt            
     * @return \Base\Entity\AbstractBaseEntity
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     *
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     *
     * @param field_type $isActive            
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
}