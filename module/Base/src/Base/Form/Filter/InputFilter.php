<?php
namespace Base\Form\Filter;

use Zend\InputFilter\InputFilter;
use Base\EventManager\EventProvider;
class InputFilter extends InputFilter
{
    protected $examsqa_base_event_provider;
    public function __construct(EventProvider $examsqa_base_event_provider){
        $this->examsqa_base_event_provider = $examsqa_base_event_provider;
    }
}