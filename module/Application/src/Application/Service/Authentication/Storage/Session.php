<?php
namespace Application\Service\Authentication\Storage;

use Zend\Authentication\Storage\Session as ZendAuthStorageSession;
use Zend\Session\ManagerInterface as SessionManager;

class Session extends ZendAuthStorageSession
{

    public function __construct($namespace = null, $member = null, SessionManager $manager = null)
    {
        parent::__construct($namespace, $member, $manager);
    }

    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}