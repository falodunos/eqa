<?php
namespace Admin\Entity\Contract\Exam;

use Base\Entity\Contract\BaseEntityInterface;

interface CertificateInterface extends BaseEntityInterface
{

    /**
     * Get certName.
     *
     * @return string
     */
    public function getCertName();

    /**
     * Set certName.
     *
     * @param string $certName            
     * @return CertificateInterface
     */
    public function setCertName($certName);
    
    /**
     * Get certCode.
     *
     * @return string
     */
    public function getCertCode();
    
    /**
     * Set certCode.
     *
     * @param string $certCode
     * @return CertificateInterface
    */
    public function setCertCode($certCode);
    

    /**
     * Get certDescription
     *
     * @return string
     */
    public function getCertDescription();

    /**
     * Set certDescription.
     *
     * @param string $certDescription            
     * @return CertificateInterface
     */
    public function setCertDescription($certDescription);
}