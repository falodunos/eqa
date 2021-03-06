<?php

namespace DoctrineORMModule\Proxy\__CG__\Admin\Entity\Academic;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Department extends \Admin\Entity\Academic\Department implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'deptName', 'deptDescription', 'deptAcronym', 'dateEstablished', 'contactPerson', 'deptPhone', 'deptEmail', 'institution', 'id', 'createdAt', 'updatedAt', 'isActive');
        }

        return array('__isInitialized__', 'deptName', 'deptDescription', 'deptAcronym', 'dateEstablished', 'contactPerson', 'deptPhone', 'deptEmail', 'institution', 'id', 'createdAt', 'updatedAt', 'isActive');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Department $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getInstitution()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInstitution', array());

        return parent::getInstitution();
    }

    /**
     * {@inheritDoc}
     */
    public function setInstitution(\Admin\Entity\Academic\Institution $institution = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInstitution', array($institution));

        return parent::setInstitution($institution);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeptName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeptName', array());

        return parent::getDeptName();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeptName($deptName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeptName', array($deptName));

        return parent::setDeptName($deptName);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeptAcronym()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeptAcronym', array());

        return parent::getDeptAcronym();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeptAcronym($deptAcronym)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeptAcronym', array($deptAcronym));

        return parent::setDeptAcronym($deptAcronym);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeptDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeptDescription', array());

        return parent::getDeptDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeptDescription($deptDescription)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeptDescription', array($deptDescription));

        return parent::setDeptDescription($deptDescription);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateEstablished()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateEstablished', array());

        return parent::getDateEstablished();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateEstablished($dateEstablished)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateEstablished', array($dateEstablished));

        return parent::setDateEstablished($dateEstablished);
    }

    /**
     * {@inheritDoc}
     */
    public function setContactPerson($contactPerson)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactPerson', array($contactPerson));

        return parent::setContactPerson($contactPerson);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactPerson()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactPerson', array());

        return parent::getContactPerson();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeptPhone($deptPhone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeptPhone', array($deptPhone));

        return parent::setDeptPhone($deptPhone);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeptPhone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeptPhone', array());

        return parent::getDeptPhone();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeptEmail($deptEmail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeptEmail', array($deptEmail));

        return parent::setDeptEmail($deptEmail);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeptEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeptEmail', array());

        return parent::getDeptEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', array());

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', array($createdAt));

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', array());

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', array($updatedAt));

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', array());

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsActive($isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', array($isActive));

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityClass()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntityClass', array());

        return parent::getEntityClass();
    }

}
