<?php


namespace App\Repository;

use App\Entity\MinimizeUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MinimizeUrlRepository
 * @package App\Repository
 */
class MinimizeUrlRepository extends ServiceEntityRepository
{
    /**
     * MinimizeUrlRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MinimizeUrl::class);
    }

    /**
     * @param MinimizeUrl $minimizeUrl
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(MinimizeUrl $minimizeUrl)
    {
        $this->getEntityManager()
            ->persist($minimizeUrl);
        $this->getEntityManager()
            ->flush($minimizeUrl);
    }

    /**
     * @param MinimizeUrl $minimizeUrl
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(MinimizeUrl $minimizeUrl)
    {
        $this->getEntityManager()
            ->remove($minimizeUrl);
        $this->getEntityManager()
            ->flush($minimizeUrl);
    }
}
