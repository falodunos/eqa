<?php
namespace ForgotPassword\Entity\GoalioForgot;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of User
 *
 * @author Solomon
 * @ORM\Entity(repositoryClass="ForgotPassword\Mapper\Service\PasswordFactory")
 * @ORM\Table(name="user_password_reset")
 */
class Password
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", name="request_key", length=255, nullable=false)
     */
    protected $requestKey;

    /**
     * @ORM\Column(type="datetime", name="request_time", nullable=false)
     */
    protected $requestTime;

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

 public function setRequestKey($key)
    {
        $this->requestKey = $key;
        return $this;
    }

    public function getRequestKey()
    {
        return $this->requestKey;
    }

    public function generateRequestKey()
    {
        $this->setRequestKey(strtoupper(substr(sha1($this->getUser()
            ->getId() . '####' . $this->getRequestTime()
            ->getTimestamp()), 0, 15)));
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setRequestTime($time)
    {
        if (! $time instanceof \DateTime) {
            $time = new \DateTime($time);
        }
        $this->requestTime = $time;
        return $this;
    }

    public function getRequestTime()
    {
        if (! $this->requestTime instanceof \DateTime) {
            $this->requestTime = new \DateTime('now');
        }
        return $this->requestTime;
    }

    public function validateExpired($resetExpire)
    {
        $expiryDate = new \DateTime($resetExpire . ' seconds ago');
        return $this->getRequestTime() < $expiryDate;
    }
}
