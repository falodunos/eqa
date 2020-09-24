<?php
namespace ForgotPassword\Mapper;

use Doctrine\ORM\EntityManager;
use GoalioForgotPassword\Options\ModuleOptions;
use Base\Repository\BaseDbRepository;

class Password extends BaseDbRepository
{

    protected $keyField = 'requestKey';

    protected $userField = 'user';

    protected $reqtimeField = 'requestTime';

    /**
     *
     * @var \GoalioForgotPassword\Options\ModuleOptions
     */
    protected $options;

    protected $_passwordEntityClass;

    protected $_qb;

    public function __construct(EntityManager $em, $meta, ModuleOptions $options)
    {
        parent::__construct($em, $meta);
        $this->options = $options;
        $this->_passwordEntityClass = $this->options->getPasswordEntityClass();
        $this->_qb = $this->_em->createQueryBuilder();
    }

    public function remove($passwordModel)
    {
        $this->_em->remove($passwordModel);
        $this->_em->flush();
    }
    
    public function find($id){
    }
    
    public function findByUser($user)
    {
        // $er = $this->em->getRepository($this->options->getPasswordEntityClass());
        return $this->findOneBy(array(
            'user' => $user
        ));
    }

    public function findByUserIdRequestKey($userId, $key)
    {
        // $er = $this->em->getRepository($this->options->getPasswordEntityClass());
        $user = $this->find($userId);
        return $this->findOneBy(array(
            'user' => $user,
            'requestKey' => $key
        ));
    }

    public function cleanExpiredForgotRequests($expiryTime = 86400)
    {
        $now = new \DateTime((int) $expiryTime . ' seconds ago');
        
        $query = $this->_qb->delete($this->_passwordEntityClass, 'password')->where($this->_qb->expr()
            ->lte('password.' . $this->reqtimeField, "'?" . $now->format('Y-m-d H:i:s') . "'"));
        $query->getQuery()->getResult();
        
        return true;
    }

    public function cleanPriorForgotRequests($userId)
    {
        $user = $this->find($userId);
        $query = $this->_qb->delete($this->_passwordEntityClass, 'password')->where($this->_qb->expr()
            ->eq('password.' . $this->userField, "'?" . $user."'"));
        $query->getQuery()->getResult();
    }

    public function persist($passwordModel)
    {
        $this->_em->persist($passwordModel);
        $this->_em->flush();
        
        return $passwordModel;
    }
}