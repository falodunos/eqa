<?php
namespace Application\Entity\User;

use Base\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of User Identity
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Application\Repository\User\IdentityRepository")
 *         @ORM\Table(name="user_identity")
 */
class Identity extends AbstractBaseEntity
{

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\User", inversedBy="identity")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", name="token", length=25, nullable=false)
     */
    protected $token;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Academic\Institution", inversedBy = "userIdentities")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="id")
     */
    protected $institution;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Academic\Department", inversedBy = "userIdentities")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    protected $department;

    /**
     *
     * @return the $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     *
     * @param field_type $token            
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
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
     * @return the $institution
     */
    public function getInstitution()
    {
        return $this->institution;
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
     * @param field_type $institution            
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
        return $this;
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
}