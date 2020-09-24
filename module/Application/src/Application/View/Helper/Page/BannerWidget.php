<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\View\Helper\Page;

use Zend\View\Helper\AbstractHelper;
use Base\Service\BaseService;

/**
 * Render View Partial Cross Module
 */
class BannerWidget extends AbstractHelper
{

    protected $examsqa_base_application_service = null;

    public function __construct(BaseService $examsqa_base_application_service)
    {
        $this->examsqa_base_application_service = $examsqa_base_application_service;
    }

    public function __invoke()
    {
        return $this->getView()->render('application/widget/page/banner');
    }
}
