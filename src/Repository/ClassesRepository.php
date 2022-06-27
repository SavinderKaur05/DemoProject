<?php

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classes>
 *
 * @method Classes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classes[]    findAll()
 * @method Classes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classes::class);
    }

    public function add(Classes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Classes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function FindClassesByStudentCount()
    {
        $conn = $this->getEntityManager()->getConnection(); 

        $sql = 'SELECT classes.id,  classes.name, COUNT(students.class_id) AS studentCount FROM classes 
            LEFT JOIN students  ON classes.id = students.class_id GROUP BY classes.id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();

    }
}
