<?php
namespace Base\EventManager\Listener;

use Zend\EventManager\ListenerAggregateInterface;

class EventsListeners implements ListenerAggregateInterface
{

    /**
     *
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
 /* (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(\Zend\EventManager\EventManagerInterface $events)
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::detach()
     */
    public function detach(\Zend\EventManager\EventManagerInterface $events)
    {
        // TODO Auto-generated method stub
        
    }


}