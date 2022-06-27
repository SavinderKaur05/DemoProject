<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Classes;
use App\Repository\ClassesRepository;
use App\Repository\AttendanceRepository;
use App\Form\AttendanceFormTyeType;
use App\Repository\StudentsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AttendancesController extends AbstractController
{
     private $AttRepo;
     private $classrepo;
     private $em;

    public function __construct(AttendanceRepository $AttRepo,ClassesRepository $classrepo,StudentsRepository $stuRepo, EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->AttRepo= $AttRepo;
      $this->classrepo=$classrepo;
      $this->stuRepo=$stuRepo;
    }

    #[Route('/attendances', name: 'attendances')]
    public function index(Request $request): Response
    {   
         $class_data=$this->classrepo->findAll();

       return $this->render('attendances/index.html.twig',[
        'class_data' => $class_data,
        'student_data' => 0,
       ]);
    }

   #[Route('/showlist',name:'showlist')]
   public function ShowList(Request $request):Response
   {
      $class_data=$this->classrepo->findAll();

     $classId = $request->request->get('ClassId');
        
      $Date = $request->request->get('Date');

      $student_List = $this->stuRepo->GetByClassId($classId);

      

       return $this->render('attendances/index.html.twig',[
        'student_data' => $student_List,
        'class_data' => $class_data,
        'Date' => $Date
       ]);
     
   }

   #[Route('/SaveAttendance',name:'SaveAttendance')]
   public function SaveAttendance(Request $request):Response
   {
   
      $array = $request->request->all();
      $Student = $array['StudentId'];  
      $Class = $array['ClassId'];
      $Status = $array['status'];
      $Date=   $array['Date'];
  
      $date=new DateTime($Date);
       //$Date = DateTime::createFromFormat('Y/m/d', $Date);
     // dd($Date);

      for($i = 0; $i<count($Student); $i++)
      {
        $Attendence = new Attendance();
        $Students = $this->stuRepo->find($Student[$i]);
        $Classs = $this->classrepo->find($Class[$i]);
        $Attendence->setClass($Classs);
        $Attendence->setStatus($Status[$i]);
        $Attendence->setStudent($Students);
        $Attendence->setDate($date);
        $this->em->persist($Attendence);
        $this->em->flush();
        $classId=$Class[$i];

      }   

      $class_data=$this->classrepo->findAll();
      
      $student_List = $this->stuRepo->GetByClassId($classId);

       return $this->render('attendances/index.html.twig',[
        'student_data' => $student_List,
        'class_data' => $class_data,
        'Date'=>$Date
         ]);
   }

    
}
