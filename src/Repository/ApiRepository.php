<?php

namespace App\Repository;

use App\Entity\Api;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;

/**
 * @method Api|null find($id, $lockMode = null, $lockVersion = null)
 * @method Api|null findOneBy(array $criteria, array $orderBy = null)
 * @method Api[]    findAll()
 * @method Api[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Api::class);
    }


    public function getProducts()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from(Product::class, 'p')
            ->select('p.name AS productname', 'p.mrp AS productmrp');

        return $qb->getQuery()->getArrayResult();

    }

    public function getUsers()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from(User::class, 'u')
            ->select('u.name AS username', 'u.mobile AS mobile');

        return $qb->getQuery()->getArrayResult();

    }

    public function getProductPost($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from(Product::class, 'p')
            ->select('p')
            ->where('p.id = :productId')->setParameter('productId', $id);


        return $qb->getQuery()->getArrayResult();     //return Array

        /* //return Object start
         $results =  $qb->getQuery()->getArrayResult();
         $data = [];
         foreach ($results as $result) {
             $data['id'] = $result['id'];
             $data['name'] = $result['name'];
         }
         //return Object end
         return $data;*/
    }


    public function updateProduct(Product $product): Product
    {
        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }

    public function removeCustomer(Product $customer)
    {
        $this->manager->remove($customer);
        $this->manager->flush();
    }


}
