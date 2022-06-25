<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        $this->em=$em;
        parent::__construct($registry, Employee::class);
    }

    public function add(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



      public function FindEmployeeDataWithOtherFeilds()
    {
        $conn = $this->getEntityManager()->getConnection(); 
        // "SELECT students.StudentId,students.ClassId, Students.Admission_Number, users.username,
        //  classtable.Name FROM users JOIN students ON users.UserId=students.UserId JOIN classtable 
        //  on classtable.ClassId = students.ClassId;"

        $sql = 'SELECT employee.Id, employee.employee_code, users.name, users.role FROM users JOIN employee ON users.Id=employee.user_id_id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

      public function SaveEmployee(Employee $employee,string $name,string $role)
    {
        try
        {
    
       $this->getEntityManager()->beginTransaction();
       $user = new Users();
       $user->setUserName($name."@123");
       $user->setPassword("123");
       $user->setRole($role);
       $user->setName($name);
       $user->setUserType("Employee");

         $this->em->persist($user);
         $this->em->flush();

         $employee->setUserId($user);
        $this->em->persist($employee);
         $this->em->flush();
         
         $this->getEntityManager()->commit();
        }
        catch(Exception $ex)
        {
          $this->getEntityManager()->rollback();
        }

    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
