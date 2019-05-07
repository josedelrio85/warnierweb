<?php

namespace AppBundle\Repository;

/**
 * PartnersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartnersRepository extends \Doctrine\ORM\EntityRepository
{
    public function findActivos()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT p FROM AppBundle:Partners p WHERE p.activo = :activo")->setParameter('activo',1);
        $resultado = $query->getResult();
        
        return $resultado;
    }
}
