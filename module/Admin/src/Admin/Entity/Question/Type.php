<?php
namespace Admin\Entity\Question;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\BaseIdentityEntity;
use Admin\Entity\Contract\Question\TypeInterface as QuestionTypeInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="question_types")
 */
class Type extends BaseIdentityEntity implements QuestionTypeInterface
{
    /* Defining entity protected member variables */

    /**
     * @ORM\Column(type="string", name ="type_name", nullable=false)
     */
    protected $typeName;

    /**
     * @ORM\Column(type="string", name="type_description", nullable =true)
     */
    protected $typeDescription;
    
    /* DEFINING ENTITY MEMBER FUNCTIONS */
    
    /**
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\TypeInterface::getTypeName()
     */
    public function getTypeName()
    {
        return $this->typeName;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\TypeInterface::setTypeName()
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\TypeInterface::getTypeDescription()
     */
    public function getTypeDescription()
    {
        return $this->typeDescription;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Admin\Entity\Contract\Question\TypeInterface::setTypeDescription()
     */
    public function setTypeDescription($typeDescription)
    {
        $this->typeDescription = $typeDescription;
        return $this;
    }

}
