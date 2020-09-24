<?php
namespace Base\Service\Contract;
interface  BaseErrorHandlingInterface{
    /**
     * 
     * @param unknown $id
     */
    public function findLog($id);
    /**
     * 
     */
    public function logError($title, $comment);
}