<?php
namespace Admin\Service;

use Admin\Service\Contract\DashboardServiceInterface;
use Base\Service\BaseService;
use Zend\ServiceManager\ServiceLocatorInterface;

class DashboardService extends BaseService implements DashboardServiceInterface
{

    /*
     * (non-PHPdoc)
     * @see \Base\Service\BaseService::getEntityDataArray()
     */
    public function getEntityDataArray($entityId)
    {
        // TODO Auto-generated method stub
    }

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    public function getDashboardHtml()
    {
        $path = '/module/Admin/view/admin/Dashboard/index.phtml';
        $file = file_get_contents(getcwd() . $path, FILE_USE_INCLUDE_PATH);
        $fileParts = explode(',', $file);
        $html = '';
        $count = 0;
        foreach ($this->findAllDashboards() as $Dashboard) {
            $count += 1;
            $status = (int) $Dashboard->getIsActive() == 1 ? 'Active' : 'In-active';
            $action = " <select data-key='data-link-to-edit-form' style='width: auto; margin:0; border: none; background: transparent;'>
                            <option value = ''>Action</option>
                            <option value=Dashboard-edit-" . $Dashboard->getId() . ">Edit</option>
                            <option value=Dashboard-delete-" . $Dashboard->getId() . ">Delete</option>
                        </select>";
            
            $html .= "<tr><td>" . $count . "</td><td>" . $Dashboard->getDashboardName() . "</td><td>" . $Dashboard->getDashboardCode() . "</td><td>" . $Dashboard->getDashboardDescription() . "</td><td>" . $status . "</td><td>" . $action . "</td></tr>";
        }
        
        return $fileParts[0] . $html . $fileParts[1];
    }
}