<?php
namespace Application\Service\Generator\Strings\Adapter;

use Application\Service\Generator\Strings\AdapterAbstract;

/**
 * Description of Alnum
 *
 * @author Solomon
 */
class Alnum extends AdapterAbstract
{

    public function generate()
    {
        $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '1234567890';
        $string = '';
        
        while (strlen($string) < $this->_length) {
            $characters = ((rand(1, 10) % 2) == 0) ? $alphabets : $numbers;
            $charSpace = strlen($characters);
            
            $charPos = rand(0, $charSpace - 1);
            
            $string .= $characters[$charPos];
        }
        return $this->toCase($string);
    }
}
