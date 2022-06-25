<?php

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        $this->em=$em;
        parent::__construct($registry, Student::class);
    }

    public function add(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
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

        $sql = 'SELECT student.Id,student.class_id_id, student.Admission_Number, users.user_name AS username,
        classes.name FROM users JOIN student ON users.Id=student.user_id_id JOIN classes ON 
        classes.Id = student.class_id_id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

    public function SaveStudent(Student $student,string $name)
    {
        try
        {
      $this->getEntityManager()->beginTransaction();
       $user = new Users();
       $user->setUserName($name."@123");
       $user->setPassword("123");
       $user->setRole("Student");
       $user->setName($name);
       $user->setUserType("Student");

         $this->em->persist($user);
         $this->em->flush();

         $student->setUserId($user);
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
//     * @return Student[] Returns an array of Student objects
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

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
