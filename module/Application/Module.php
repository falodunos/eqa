<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use BjyAuthorize\View\RedirectionStrategy;
use Zend\View\Helper\Navigation as ZendViewHelperNavigation;
use Application\EventManager\Listener\EventsListeners;

class Module implements AutoloaderProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager(); // get application service manager
        $eventManager = $e->getApplication()->getEventManager(); // get event manager
        
        $eventManager->attach(new EventsListeners());
        
        // Add ACL information to the Navigation view helper
        $authorize = $sm->get('BjyAuthorize\Service\Authorize');
        
        try{
            $acl = $authorize->getAcl();
            $role = $authorize->getIdentity();
            ZendViewHelperNavigation::setDefaultAcl($acl);
            ZendViewHelperNavigation::setDefaultRole($role);

            $moduleRouteListener = new ModuleRouteListener(); // initialize the module listener ...
            $strategy = new RedirectionStrategy(); // Enable BjyAuthorize View RedirectionStrategy
            $strategy->setRedirectRoute('zfcuser'); // eventually set the route name (default is ZfcUser's login route)
            
            $eventManager->attach($strategy);
            $moduleRouteListener->attach($eventManager);
        }catch(\Exception $ex){
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoLoader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}
