<?php
namespace Application\Options;
use ZfcUser\Options\RegistrationOptionsInterface as zfcUserRegistrationOptions;

interface RegistrationOptionsInterface extends zfcUserRegistrationOptions
{
    /**
     * set enable last name
     *
     * @param bool $flag
     * @return ModuleOptions
     */
    public function setEnableLastName($enableLastName);
    
    /**
     * get enable last name
     *
     * @return bool
    */
    public function getEnableLastName();
    
    /**
     * set enable first name
     *
     * @param bool $flag
     * @return ModuleOptions
     */
    public function setEnableFirstName($enableFirstName);
    
    /**
     * get enable first name
     *
     * @return bool
    */
    public function getEnableFirstName();
    
    /**
     * set enable phone
     *
     * @param bool $flag
     * @return ModuleOptions
     */
    public function setEnablePhoneNumber($enablePhoneNumber);
    
    /**
     * get enable phone number
     *
     * @return bool
    */
    public function getEnablePhoneNumber();
}