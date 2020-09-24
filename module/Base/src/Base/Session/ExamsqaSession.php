<?php
namespace Base\Session;

use Zend\Session\Container as SessionContainer;
use Zend\Session\ManagerInterface as Manager;

class ExamsqaSession extends SessionContainer
{

    public function __construct($name = 'Default', Manager $manager = null)
    {
        parent::__construct($name, $manager);
    }
}