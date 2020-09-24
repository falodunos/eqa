<?php
namespace Admin\Service\Contract\Exam;

use Admin\Entity\Contract\Exam\CertificateInterface;

interface CertificateServiceInterface
{

    public function findAllCertificates();

    /**
     *
     * @param integer $id            
     */
    public function findCertificate($id);

    /**
     *
     * @param ExamInterface $level            
     */
    public function saveCertificate($certificate_data);

    /**
     *
     * @param ExamInterface $level            
     */
    public function deleteCertificate(CertificateInterface $certificate);
    
    public function findCertificateBy(array $criteria);
}