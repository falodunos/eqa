<?php

namespace DoctrineORMModule\Proxy\__CG__\Admin\Entity\Question;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Section extends \Admin\Entity\Question\Section implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'sectionInfo', 'sectionName', 'sectionDescription', 'sectionPaper', 'questions', 'institution', 'department', 'id', 'createdAt', 'updatedAt', 'isActive');
        }

        return array('__isInitialized__', 'sectionInfo', 'sectionName', 'sectionDescription', 'sectionPaper', 'questions', 'institution', 'department', 'id', 'createdAt', 'updatedAt', 'isActive');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Section $proxy) {
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
    public function addQuestions(\Doctrine\Common\Collections\Collection $questions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addQuestions', array($questions));

        return parent::addQuestions($questions);
    }

    /**
     * {@inheritDoc}
     */
    public function removeQuestions(\Doctrine\Common\Collections\Collection $questions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeQuestions', array($questions));

        return parent::removeQuestions($questions);
    }

    /**
     * {@inheritDoc}
     */
    public function getSectionInfo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSectionInfo', array());

        return parent::getSectionInfo();
    }

    /**
     * {@inheritDoc}
     */
    public function setSectionInfo($sectionInfo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSectionInfo', array($sectionInfo));

        return parent::setSectionInfo($sectionInfo);
    }

    /**
     * {@inheritDoc}
     */
    public function getSectionName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSectionName', array());

        return parent::getSectionName();
    }

    /**
     * {@inheritDoc}
     */
    public function getSectionDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSectionDescription', array());

        return parent::getSectionDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setSectionName($sectionName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSectionName', array($sectionName));

        return parent::setSectionName($sectionName);
    }

    /**
     * {@inheritDoc}
     */
    public function setSectionDescription($sectionDescription)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSectionDescription', array($sectionDescription));

        return parent::setSectionDescription($sectionDescription);
    }

    /**
     * {@inheritDoc}
     */
    public function setSectionPaper($sectionPaper)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSectionPaper', array($sectionPaper));

        return parent::setSectionPaper($sectionPaper);
    }

    /**
     * {@inheritDoc}
     */
    public function getSectionPaper()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSectionPaper', array());

        return parent::getSectionPaper();
    }

    /**
     * {@inheritDoc}
     */
    public function getQuestions()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuestions', array());

        return parent::getQuestions();
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
    public function getDepartment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDepartment', array());

        return parent::getDepartment();
    }

    /**
     * {@inheritDoc}
     */
    public function setInstitution(\Admin\Entity\Academic\Institution $institution)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInstitution', array($institution));

        return parent::setInstitution($institution);
    }

    /**
     * {@inheritDoc}
     */
    public function setDepartment(\Admin\Entity\Academic\Department $department)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDepartment', array($department));

        return parent::setDepartment($department);
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
