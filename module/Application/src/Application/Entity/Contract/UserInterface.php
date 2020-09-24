<?php
namespace Application\Entity\Contract;
use ZfcUser\Entity\UserInterface as zfcUserInterface;
interface UserInterface extends zfcUserInterface{
    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName();
    
    /**
     * Set firstName.
     *
     * @param string $firstName
     * @return UserInterface
    */
    public function setFirstName($firstName);
    
    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName();
    
    /**
     * Set lastName.
     *
     * @param string $lastName
     * @return UserInterface
    */
    public function setLastName($lastName);
    
    /**
     * Get phone number.
     *
     * @return string
     */
    public function getPhoneNumber();
    
    /**
     * Set phone.
     *
     * @param string $phoneNumber
     * @return UserInterface
    */
    public function setPhoneNumber($phoneNumber);
    
    /**
     * Get institution.
     *
     */
    public function getInstitution();
    
    /**
     * Set phone.
     *
     * @param string $institution
     * @return UserInterface
    */
    public function setInstitution($institution);
}