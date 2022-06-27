<?php

namespace App\Repository;

use App\Entity\Employees;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Employees>
 *
 * @method Employees|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employees|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employees[]    findAll()
 * @method Employees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeesRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        $this->em=$em;
        parent::__construct($registry, Employees::class);
    }

    public function add(Employees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employees $entity, bool $flush = false): void
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

        $sql = 'SELECT employees.Id, employees.employee_code,employees.role, employees.name, employees.employee_code FROM users JOIN employees ON users.Id=employees.user_id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

      public function SaveEmployee(Employees $employee,string $role)
    {
        try
        {
    
       $this->getEntityManager()->beginTransaction();
       $user = new User();
       $user->setUserName($employee->getName()."@123");
       $user->setPassword($employee->getName()."1234");
       $roles[]=$role;
       $user->setRoles($roles);

         $this->em->persist($user);
         $this->em->flush();
      

         $employee->setUser($user);
         
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
