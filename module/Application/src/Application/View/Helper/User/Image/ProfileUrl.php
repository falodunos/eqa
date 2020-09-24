<?php
namespace Application\View\Helper\User\Image;

use Zend\View\Helper\AbstractHelper;

class ProfileUrl extends AbstractHelper
{

    public function __invoke($basePath, $zfcUserIdentity)
    {
        $defaultProfileImageUrl = $basePath . '/img/user/profile/default.png';
        $userProfileImageUrl = $basePath . '/img/user/profile/'.$zfcUserIdentity->getId().'.png';
        
        if (file_exists($userProfileImageUrl) && is_file($userProfileImageUrl)){
            return $userProfileImageUrl;
        }
        
        return $defaultProfileImageUrl;
    }
}