<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Employee;
use App\Entity\Student;
use App\Entity\Users;
use App\Form\EmployeeFormType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EmployeesController extends AbstractController
{
     private $EmployeeRepo;
     private $em;

    public function __construct(EmployeeRepository $EmployeeRepo, EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->EmployeeRepo= $EmployeeRepo;
      
    }

    #[Route('/createemployee', name: 'createemployee')]
    public function create(Request $request): Response
    {
      $form = $this->createForm(EmployeeFormType::class);

      $form->handleRequest($request);
       $employee=new Employee();

      if($form->isSubmitted() && $form->isValid())
      {
        $employee->setEmployeeCode($form->get('EmployeeCode')->getData());
        
        $user=new Users();
        $user->setName($form->get('inputName')->getData());
        $user->setPassword($form->get('inputName')->getData().'@123');
        $user->setRole($form->get('role')->getData());
        $user->setUserType('Employee');
        $user->setUserName($form->get('inputName')->getData().'@1');
        
        // //User Created 
        $this->em->persist($user);
        $this->em->flush();

        $employee->setUserId($user);

        //student Created
        $this->em->persist($employee);
        $this->em->flush();


        return $this->redirectToRoute('createemployee');
      }

        $employeesdata =  $this->EmployeeRepo->FindEmployeeDataWithOtherFeilds();

        return $this->render('employees/AddEmployee.html.twig',[
        'form' => $form->createView(),
        'employee_data' => $employeesdata,
       ]);

    }

   #[Route('/deleteemployeedata/{id}', name: 'deleteemployeedata')]
    public function DeleteEmployee($id)
    {
        $employeedata =  $this->EmployeeRepo->find($id);

        $employeesdata =  $this->EmployeeRepo->FindEmployeeDataWithOtherFeilds();

        $this->EmployeeRepo->remove($employeedata);
        $this->em->flush();
        return $this->redirectToRoute('createemployee');
        
        $form = $this->createForm(EmployeeFormType::class);

        return $this->render('employees/AddEmployee.html.twig',[
        'form' => $form->createView(),
        'employee_data' => $employeesdata,

       ]);
    }

//     #[Route('/updatestudentdata/{id}',name:'updatestudentdata')]
//     public function UpdateEmployee($id,Request $request)
//     {
//         $studentdata =  $this->StudentRepo->find($id);
//         $studentsdata =  $this->StudentRepo->FindStudentDataWithOtherFeilds();

//         $form = $this->createForm(StudentFormType::class,$studentdata);
//         $form->handleRequest($request);

//       if($form->isSubmitted() && $form->isValid())
//       {
//          $studentdata->setAdmissionNumber($form->get('Admission_Number')->getdata());
//          $this->em->flush();
//           return $this->redirectToRoute('createstudent');
     
//       }
//         return $this->render('classes/AddClass.html.twig',[
//         'form' => $form->createView(),
//         'student_data' => $studentsdata, 
//        ]);
//     }
}
