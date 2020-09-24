<?php
namespace Application\Service\Generator\Strings\Adapter;

use Application\Service\Generator\Strings\AdapterAbstract;

/**
 * Description of Alphabet
 *
 * @author Solomon
 */
class Alphabet extends AdapterAbstract
{

    public function generate()
    {
        $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        while (strlen($string) < $this->_length) {
            $charSpace = strlen($alphabets);
            $charPos = rand(0, $charSpace - 1);
            $string .= $alphabets[$charPos];
        }
        return $this->toCase($string);
    }
}
