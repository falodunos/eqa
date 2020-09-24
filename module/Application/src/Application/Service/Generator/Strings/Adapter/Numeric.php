<?php
namespace Application\Service\Generator\Strings\Adapter;

use Application\Service\Generator\Strings\AdapterAbstract;

/**
 * Description of Numeric
 *
 * @author Solomon
 */
class Numeric extends AdapterAbstract
{

    public function generate()
    {
        $numeric = '1234567890';
        $string = '';
        $charSpace = strlen($numeric);
        while (strlen($string) < $this->_length) {
            $charPos = rand(0, $charSpace - 1);
            $string .= $numeric[$charPos];
        }
        return $string;
    }
}
