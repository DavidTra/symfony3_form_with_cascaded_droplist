<?php

namespace TEST2\RegistrationBundle\Repository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByProvinceId($province_id)
    {
        $qb = $this->createQueryBuilder('city');

        $qb ->join('city.province', 'province')
            ->andwhere('province.id = :id')
                ->setParameter('id', $province_id);

        return $qb ->getQuery()
                   ->getResult();
    }

}
