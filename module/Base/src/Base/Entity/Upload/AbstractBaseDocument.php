<?php
namespace Base\Entity\Upload;

use Base\Entity\Contract\BaseDocumentInterface;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Academic\Department;
use Admin\Entity\Academic\Institution;

/*
 * @MappedSuperclass
 */
abstract class AbstractBaseDocument implements BaseDocumentInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(name="document_name",type="string", length=255, nullable=false)
     */
    protected $documentName;

    /**
     * @ORM\Column(name="document_description",type="string", length=255, nullable=false)
     */
    protected $documentDescription;

    /**
     * @ORM\Column(name="document_path", type="text", nullable=false)
     */
    protected $documentPath;

    /**
     * @ORM\Column(name="created_at",type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", name="is_active", length=1, nullable=false, options={"default":"1"})
     */
    protected $isActive;

    /**
     *
     * @return the $documentDescription
     */
    public function getDocumentDescription()
    {
        return $this->documentDescription;
    }

    /**
     *
     * @param field_type $documentDescription            
     */
    public function setDocumentDescription($documentDescription)
    {
        $this->documentDescription = $documentDescription;
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
    public function setInstitution(Institution $institution)
    {
        $this->institution = $institution;
        return $this;
    }

    /**
     *
     * @param field_type $department            
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getDocumentName()
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::setDocumentName()
     */
    public function setDocumentName($documentName)
    {
        // remove all characters except alphabet and digits from document name ...
        
        $this->documentName = $this->getCorrectFileName($documentName['name']);
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getDocumentPath()
     */
    public function getDocumentPath()
    {
        return $this->documentPath;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::setDocumentPath()
     */
    public function setDocumentPath($documentPath)
    {
        $this->documentPath = $documentPath;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getCreatedAt()
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::setCreatedAt()
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getUpdatedAt()
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::setUpdatedAt()
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::getIsActive()
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Base\Entity\Contract\BaseDocumentInterface::setIsActive()
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    protected function getCorrectFileName($fileName)
    {
        $fileName = preg_replace('/[^a-z0-9_\\-\\.]+/i', '_', $fileName);
        $fileInfo = pathinfo($fileName);
        
        if (preg_match('/^_+$/', $fileInfo['filename'])) {
            $fileName = 'file.' . $fileInfo['extension'];
        }
        return $fileName;
    }
}