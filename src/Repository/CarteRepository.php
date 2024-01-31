<?php

namespace App\Repository;

use App\Entity\Carte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carte>
 *
 * @method Carte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carte[]    findAll()
 * @method Carte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carte::class);
    }

    public function add(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function searchpays($mots){
        $query = $this->createQueryBuilder('a');
        
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(a.Titre_PaysC,a.CapitaleC, a.Desc_PaysC) AGAINST(:mots boolean)>0')
            ->setParameter('mots', $mots);
        }
        return $query->getQuery()->getResult();
    }
    public function supprimerPays($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql ='DELETE FROM carte WHERE id = :id';

        $stmt = $conn->prepare($sql);
        
        $resultSet = $stmt->executeQuery(['id' => $id] );

        $resultat = $resultSet->fetchAllAssociative();
        
        return $resultSet->fetchAllAssociative();
    }
    public function remove(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**public function sendmodification(bool $modifications){
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'INSERT INTO Modifications VALUES '
    }*/

//    /**
//     * @return Carte[] Returns an array of Carte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Carte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
