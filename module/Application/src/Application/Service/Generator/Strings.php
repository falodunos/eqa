<?php
namespace Application\Service\Generator;

use Application\Service\Generator\Strings\AdapterAbstract;
use Application\Service\Generator\Strings\Adapter\Alnum;
use Application\Service\Generator\Strings\Adapter\Numeric;
use Application\Service\Generator\Strings\Adapter\Alphabet;

/**
 * Description of StringGenerator
 *
 * @author Solomon
 */
class Strings
{

    protected $_adapter;

    protected $modelString = null;

    public function __construct(AdapterAbstract $adapter = null)
    {
        $this->_adapter = is_null($adapter) ? new Alnum() : $adapter;
    }

    public function generate($case = AdapterAbstract::GEN_STRING_MCASE, $length = 10)
    {
        $string = $this->_adapter->setCase($case)
            ->setLength($length)
            ->generate();
        return $string;
    }

    public static function getRandomAdapter()
    {
        $adapters = [];
        $adapters[] = new Numeric();
        $adapters[] = new Alphabet();
        $adapters[] = new Alnum();
        $adapter = $adapters[array_rand($adapters, 1)];
        return $adapter;
    }
}
