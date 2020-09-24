<?php
namespace Admin\Form\Exam;

use Base\Form\Fieldset\CommonFieldset;
use Admin\Form\Fieldset\Exam\CertificateFieldset;
use Doctrine\ORM\EntityManager as ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Form\Base as BaseForm;

class CertificateForm extends BaseForm
{

    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct('certificate-form');
        // The form will hydrate an object of type "Certificate"
        $this->setHydrator(new DoctrineHydrator($entityManager));
        $this->setAttributes(array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'id' => 'exam-certificate-form'
        ));
        // Add the user fieldset, and set it as the base fieldset
        $certificateFieldset = new CertificateFieldset($entityManager);
        $certificateFieldset->setUseAsBaseFieldset(true);
        $this->add($certificateFieldset);
        
        $this->add(new CommonFieldset());
    }
}