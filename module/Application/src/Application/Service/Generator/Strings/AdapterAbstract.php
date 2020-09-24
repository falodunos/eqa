<?php
namespace Application\Service\Generator\Strings;
// use Zend\ServiceManager\ServiceLocatorInterface;
// use Zend\ServiceManager\ServiceManagerAwareInterface;
// use Zend\ServiceManager\ServiceManager;

/**
 * Description of AdapterAbstract
 *
 * @author Solomon
 */
abstract class AdapterAbstract
{

    const GEN_STRING_UCASE = 'ucase';

    const GEN_STRING_LCASE = 'lcase';

    const GEN_STRING_MCASE = 'mcase';

    protected $_case;

    protected $_length = 10;

    public abstract function generate();

    public function setCase($case)
    {
        $this->_case = $case;
        return $this;
    }

    public function setUpperCase()
    {
        $this->_case = self::GEN_STRING_UCASE;
        return $this;
    }

    public function setMixedCase()
    {
        $this->_case = self::GEN_STRING_MCASE;
        return $this;
    }

    public function setLowerCase()
    {
        $this->_case = self::GEN_STRING_LCASE;
        return $this;
    }

    public function setLength($value)
    {
        $this->_length = $value;
        return $this;
    }

    public function toCase($string)
    {
        switch ($this->_case) {
            default:
            case self::GEN_STRING_MCASE:
                break;
            case self::GEN_STRING_LCASE:
                $string = strtolower($string);
                break;
            case self::GEN_STRING_UCASE:
                $string = strtoupper($string);
                break;
        }
        
        return $string;
    }
}
