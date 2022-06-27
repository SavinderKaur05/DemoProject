<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attendance>
 *
 * @method Attendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendance[]    findAll()
 * @method Attendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    public function add(Attendance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Attendance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function GetAttendanceByDateAndClassId(int $classId,string $date)
    {
        $conn = $this->getEntityManager()->getConnection(); 

        $sql = "SELECT students.name AS StuName, students.Admission_Number , classes.name , attendance.Status FROM
         students JOIN classes JOIN attendance ON attendance.class_id = classes.Id AND
         attendance.student_id = students.id WHERE attendance.class_id = '$classId' AND attendance.date = '$date';";

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }
}
