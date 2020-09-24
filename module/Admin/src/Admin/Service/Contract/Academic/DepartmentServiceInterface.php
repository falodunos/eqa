<?php
namespace Admin\Service\Contract\Academic;

use Admin\Entity\Contract\Academic\DepartmentInterface;

interface DepartmentServiceInterface
{

    public function findAllDepartments();

    /**
     *
     * @param integer $id            
     */
    public function findDepartment($id);

    /**
     *
     * @param DepartmentInterface $department            
     */
    public function saveDepartment($post);

    /**
     *
     * @param DepartmentInterface $department            
     */
    public function deleteDepartment(DepartmentInterface $department);
    
    public function findDepartmentBy(array $criteria);
}