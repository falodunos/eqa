<?php
namespace Base\Repository\Contract;

interface BaseDbRepositoryInterface
{

    public function findById($id);

    public function insert($entity);

    public function update($entity);

    public function select($entity);

    public function delete($entity);

    public function getExamsqaBaseEventProvider();

    public function setEntityClass($entity_class_name);

    public function getEntityClass();
    
    public function getEntityManager();
}
