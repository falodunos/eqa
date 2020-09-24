<?php
namespace Admin\Entity\Exam;

use Base\Entity\BaseIdentityEntity;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Contract\Exam\CertificateInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author Solomon
 *         @ORM\Entity(repositoryClass="Admin\Repository\Exam\CertificateRepository")
 *         @ORM\Table (name="exam_certificates")
 */
class Certificate extends BaseIdentityEntity implements CertificateInterface
{
    /* Defining entity protected member variables */
    /**
     * @ORM\Column(name="cert_name", type="string", length=50, nullable=false)
     */
    protected $certName;

    /**
     * @ORM\Column(name="cert_code", type="string",length=10, nullable=true)
     */
    protected $certCode;

    /**
     * @ORM\Column(name="cert_description", type="string", length = 100, nullable=true)
     */
    protected $certDescription;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Exam", mappedBy="examCertificate")
     */
    private $exams;
    
    public function __construct()
    {
        $this->exams = new ArrayCollection();
    }
    
    /* Defining entity relationships */
    
    /**
     *
     * @return the $certName
     */
    public function getCertName()
    {
        return $this->certName;
    }

    /**
     *
     * @return the $certDescription
     */
    public function getCertDescription()
    {
        return $this->certDescription;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Exam\CertificateInterface::getCertCode()
     */
    public function getCertCode()
    {
        return $this->certCode;
    }

    /**
     *
     * @param field_type $certName            
     */
    public function setCertName($certName)
    {
        $this->certName = $certName;
        return $this;
    }

    /**
     *
     * @param field_type $certDescription            
     */
    public function setCertDescription($certDescription)
    {
        $this->certDescription = $certDescription;
        return $this;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Exam\CertificateInterface::setCertCode()
     */
    public function setCertCode($certCode)
    {
        $this->certCode = $certCode;
        return $this;
    }

}