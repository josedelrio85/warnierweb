<?php

namespace AppBundle\Repository;

/**
 * recAsociadoRepository
 *
 */
class recAsociadoRepository extends \Doctrine\ORM\EntityRepository {

    public function recursosSubarticulo($idSubarticulo) {

        $em = $this->getEntityManager();
        $query = $em->createQuery('select r FROM AppBundle:recAsociado r WHERE r.idSubarticulo = :idSubarticulo AND r.activo = :activo')
                ->setParameter('idSubarticulo', $idSubarticulo)
                ->setParameter('activo', 1);
        $resultado = $query->getResult();

        return $resultado;
    }
}
