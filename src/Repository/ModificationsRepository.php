<?php

namespace App\Repository;

use App\Entity\Modifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Modifications>
 *
 * @method Modifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modifications[]    findAll()
 * @method Modifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modifications::class);
    }
    //sert à enregistrer dans la table carte la modifications
    public function valideModificationsPays(int $id ): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        /*$selectmodifpays = 'SELECT modif_pays_desc_m FROM modifications WHERE id=:id';

        $selectidpays ='SELECT ancienneidpays FROM modifications WHERE id=:id';*/

        $sql = 'UPDATE Carte SET desc_pays_c =  (SELECT modif_pays_desc_m FROM modifications WHERE id=:id) WHERE id = (SELECT ancienneidpays FROM modifications WHERE id=:id)';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);
        
        $resultSet = $stmt->executeQuery(['id' => $id/*, 'selectmodifpays' => $selectmodifpays, 'selectidpays' => $selectidpays*/]);

        $sql = ' DELETE FROM modifications WHERE id=:id';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $resultat = $resultSet->fetchAllAssociative();

        return $resultSet->fetchAllAssociative();
        /*$conn = $this->getEntityManager()->getConnection();

        /*if ($conn->isConnected()){
            dump( "Connected");
        }
        else {
            dump("Not connected");
        }

        $sql = 'UPDATE regions SET desc_regions_r = :texte WHERE id = :id';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['id' => $id, 'texte' => $texte] );

        $sql ='DELETE FROM modifications WHERE id = :idmodifications ';

        $stmt = $conn->prepare($sql);
        
        $resultSet = $stmt->executeQuery(['idmodifications' => $idmodifications] );

        $resultat = $resultSet->fetchAllAssociative();
        
        return $resultSet->fetchAllAssociative();*/

      
    }
   
    public function valideModificationsRegions(int $id ): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        /*$selectmodifpays = 'SELECT modif_pays_desc_m FROM modifications WHERE id=:id';

        $selectidpays ='SELECT ancienneidpays FROM modifications WHERE id=:id';*/

        $sql = 'UPDATE Regions SET desc_regions_r =  (SELECT modif_regions_desc_m FROM modifications WHERE id=:id) WHERE id = (SELECT ancienneidregions FROM modifications WHERE id=:id)';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);
        
        $resultSet = $stmt->executeQuery(['id' => $id/*, 'selectmodifpays' => $selectmodifpays, 'selectidpays' => $selectidpays*/]);

        $sql = ' DELETE FROM modifications WHERE id=:id';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $resultat = $resultSet->fetchAllAssociative();

        return $resultSet->fetchAllAssociative();
        /*$conn = $this->getEntityManager()->getConnection();

        /*if ($conn->isConnected()){
            dump( "Connected");
        }
        else {
            dump("Not connected");
        }

        $sql = 'UPDATE regions SET desc_regions_r = :texte WHERE id = :id';
                //DELETE FROM modifications WHERE id = :idmodifications ;

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['id' => $id, 'texte' => $texte] );

        $sql ='DELETE FROM modifications WHERE id = :idmodifications ';

        $stmt = $conn->prepare($sql);
        
        $resultSet = $stmt->executeQuery(['idmodifications' => $idmodifications] );

        $resultat = $resultSet->fetchAllAssociative();
        
        return $resultSet->fetchAllAssociative();*/

      
    }



    //sert à supprimer une modification
    public function annulerModification(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

           $sql = ' DELETE FROM modifications WHERE id=:id';
   
           $stmt = $conn->prepare($sql);
           $resultSet = $stmt->executeQuery(['id' => $id]);
           $resultat = $resultSet->fetchAllAssociative();
        
            return $resultSet->fetchAllAssociative();
       /* $conn = $this->getEntityManager()->getConnection();

        $sql = 'DELETE FROM modifications WHERE id = :idmodifications ';
        
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['idmodifications' => $idmodifications] );

        $resultat = $resultSet->fetchAllAssociative();
        
        return $resultSet->fetchAllAssociative();*/


    }

    public function selectionnerPays(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM modifications WHERE modif_pays_desc_m IS NOT NULL';
        
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();
        $resultat = $resultSet->fetchAllAssociative();
        
        return $resultat;
    }
    //sert à compter le nombre de modifications
    /*public function compteModifications(){
        $em = $this->getDoctrine()->getManager();

        $repoModifications = $em-getReposiotry(compteModifications::class);

        $totalModifications = $repoModifications->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return new Response($totalModifications);
    }*/
    public function add(Modifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Modifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Modifications[] Returns an array of Modifications objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Modifications
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
