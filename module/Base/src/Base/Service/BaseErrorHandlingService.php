<?php
namespace Base\Service;

use Base\Service\Contract\BaseErrorHandlingInterface;
use Zend\Log\Logger;

class BaseErrorHandlingService implements BaseErrorHandlingInterface
{

    protected $_zendLogger = null;

    public function __construct(Logger $zendLogger)
    {
        $this->_zendLogger = $zendLogger;
    }
    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\ErrorHandlingInterface::findLog()
     */
    public function findLog($id)
    {
        // TODO Auto-generated method stub
    }
    
    /*
     * (non-PHPdoc)
     * @see \Application\Service\Contract\ErrorHandlingInterface::logError()
     */
    public function logError($title, $comment)
    {
        // TODO Auto-generated method stub
    }
}