<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\Students;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Students>
 *
 * @method Students|null find($id, $lockMode = null, $lockVersion = null)
 * @method Students|null findOneBy(array $criteria, array $orderBy = null)
 * @method Students[]    findAll()
 * @method Students[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentsRepository extends ServiceEntityRepository
{
   private $em;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        $this->em=$em;
        parent::__construct($registry, Students::class);
    }

    public function add(Students $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Students $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     public function FindStudentDataWithOtherFeilds()
    {

        $conn = $this->getEntityManager()->getConnection(); 
        // "SELECT students.StudentId,students.ClassId, Students.Admission_Number, users.username,
        //  classtable.Name FROM users JOIN students ON users.UserId=students.UserId JOIN classtable 
        //  on classtable.ClassId = students.ClassId;"

        // SELECT student.Id,student.class_id_id, student.Admission_Number,
        // classes.name FROM users JOIN student ON users.Id=student.user_id_id JOIN classes ON 
        // classes.Id = student.class_id_id

        $sql = 'SELECT students.Id,students.name AS studentsName, students.class_id,students.Admission_Number,
        classes.name FROM classes JOIN students ON classes.Id = students.class_id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

    public function GetStudentDataWithExtraFeilds(int $id)
    {
        $conn = $this->getEntityManager()->getConnection(); 

       $sql='SELECT students.Id,students.class_id, students.Admission_Number 
         FROM classes JOIN students ON classes.Id = students.class_id WHERE students.Id = '.$id.';';
      

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative(); 
    }

    public function SaveStudent(Students $student)
    {
        try
        {
      $this->getEntityManager()->beginTransaction();
       $user = new Users();
       $user->setUserName($student->getName()."@123");
       $user->setPassword("123");

         $this->em->persist($user);
         $this->em->flush();

         $student->setUser($user);
          $this->em->persist($student);
         $this->em->flush();
         
         $this->getEntityManager()->commit();
        }
        catch(Exception $ex)
        {
          $this->getEntityManager()->rollback();
        }

    }

//    /**
//     * @return Students[] Returns an array of Students objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Students
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
