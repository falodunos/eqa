<?php
namespace Admin\Entity\Contract\Question;

use Base\Entity\Contract\BaseEntityInterface;

interface TypeInterface extends BaseEntityInterface
{

    /**
     * Get TypeName.
     *
     * @return string
     */
    public function getTypeName();

    /**
     * Set TypeName.
     *
     * @param string $typeName            
     * @return TypeInterface
     */
    public function setTypeName($typeName);

    /**
     * Get TypeDescription.
     *
     * @return string
     */
    public function getTypeDescription();

    /**
     * Set TypeDescription.
     *
     * @param string $typeDescription            
     * @return TypeInterface
     */
    public function setTypeDescription($typeDescription);
}