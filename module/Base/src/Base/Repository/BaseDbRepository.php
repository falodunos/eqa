<?php
namespace Base\Repository;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Base\Repository\Contract\BaseDbRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Base\Entity\Status;

class BaseDbRepository extends EntityRepository implements BaseDbRepositoryInterface
{

    /**
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $_entity_class_name;

    private $_default_entity_action = null;

    public function findById($id)
    {
        return $this->find($id);
    }

    public function insert($entity, $tableName = null, DoctrineHydrator $hydrator = null)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
        return $entity;
    }

    public function select($entity, $tableName = null, DoctrineHydrator $hydrator = null)
    {
        return $this->persist($entity);
    }

    public function update($entity, $where = null, $tableName = null, DoctrineHydrator $hydrator = null)
    {
        $this->_em->flush();
        return $entity;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Base\Repository\Contract\BaseDbRepositoryInterface::delete()
     */
    public function delete($entity)
    {
        try {
            $this->_em->remove($entity);
            $this->_em->flush();
            return true; // return true if delete operation is successful i.e without exception
        }catch(\Exception $ex){
            return false; // return false if delete operation fails
        }
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->_em = $em;
    }

    public function getEntityManager()
    {
        return $this->_em;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Base\Repository\Contract\BaseDbRepositoryInterface::getExamsqaBaseEventProvider()
     */
    public function getExamsqaBaseEventProvider()
    {}
    
    /*
     * (non-PHPdoc)
     * @see \Base\Repository\Contract\BaseDbRepositoryInterface::setEntityClass()
     */
    public function setEntityClass($entity_class_name)
    {
        $this->_entity_class_name = $entity_class_name;
    }
    
    /*
     * (non-PHPdoc)
     * @see \Base\Repository\Contract\BaseDbRepositoryInterface::getEntityClass()
     */
    Public function getEntityClass()
    {
        return $this->_class->getName();
//         return $this->_entity_class_name;
    }

    public function getStatusOptions()
    {
        $status = new Status();
        $re = $this->_em->getRepository($status->getEntityClass());
        return $re->findAll();
    }

    public function getStatusOptionsAsArrayKeyedByValue()
    {        
        return $this->getStatusOptions();
    }
}