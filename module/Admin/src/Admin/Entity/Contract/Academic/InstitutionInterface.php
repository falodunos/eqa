<?php
namespace Admin\Entity\Contract\Academic;

use Base\Entity\Contract\BaseEntityInterface;

interface InstitutionInterface extends BaseEntityInterface
{

    /**
     * Get instName.
     *
     * @return string
     */
    public function getInstName();

    /**
     * Set instName.
     *
     * @param string $instName            
     * @return InstitutionInterface
     */
    public function setInstName($instName);

    /**
     * Get instAcronym
     *
     * @return string
     */
    public function getInstAcronym();

    /**
     * Set instAcronym.
     *
     * @param string $instAcronym            
     * @return InstitutionInterface
     */
    public function setInstAcronym($instAcronym);

    /**
     * Get instDesctiption.
     *
     * @return string
     */
    public function getInstDescription();

    /**
     * Set instDescription.
     *
     * @param string $instDescription            
     * @return InstitutionInterface
     */
    public function setInstDescription($instDescription);

    /**
     * Set contactPerson.
     *
     * @param string $contactPerson            
     * @return InstitutionInterface
     */
    public function setContactPerson($contactPerson);

    /**
     * Get contactPerson.
     *
     * @return string
     */
    public function getContactPerson();

    /**
     * Set instPhone.
     *
     * @param string $instPhone            
     * @return InstitutionInterface
     */
    public function setInstPhone($instPhone);

    /**
     * Get instPhone.
     *
     * @return string
     */
    public function getInstPhone();

    /**
     * Set instEmail.
     *
     * @param string $instEmail            
     * @return InstitutionInterface
     */
    public function setInstEmail($instEmail);

    /**
     * Get instEmail.
     *
     * @return string
     */
    public function getInstEmail();

    /**
     * Get dateEstablished.
     *
     * @return string
     */
    public function getDateEstablished();

    /**
     * Set dateEstablished.
     *
     * @param string $dateEstablished            
     * @return InstitutionInterface
     */
    public function setDateEstablished($dateEstablished);

    /**
     * Get getUser.
     * 
     * @return the $user
     */
    public function getUser();

    /**
     * Set userId.
     *
     * @param string $user            
     * @return InstitutionInterface
     */
    public function setUser($user);
}