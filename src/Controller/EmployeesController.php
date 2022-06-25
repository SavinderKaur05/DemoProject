<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Employees;
use App\Entity\Student;
use App\Entity\Users;
use App\Form\EmployeesFormType;
use App\Repository\EmployeesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EmployeesController extends AbstractController
{
     private $EmployeeRepo;
     private $em;

    public function __construct(EmployeesRepository $EmployeeRepo, EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->EmployeeRepo= $EmployeeRepo;
      
    }

    #[Route('/createemployee', name: 'createemployee')]
    public function create(Request $request): Response
    {
       $Employee = new Employees();
      $form = $this->createForm(EmployeesFormType::class,$Employee);

      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid())
      {
        $employee = $form->getData();
        $role= $form->get('role')->getData();
      
         $this->EmployeeRepo->SaveEmployee($employee,$role);

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
        
        $form = $this->createForm(EmployeesFormType::class);

        return $this->render('employees/AddEmployee.html.twig',[
        'form' => $form->createView(),
        'employee_data' => $employeesdata,

       ]);
    }

 #[Route('/updateemployeedata/{id}',name:'updateemployeedata')]
    public function UpdateStudent($id,Request $request)
    {
        $employeedata =  $this->EmployeeRepo->find($id);
        
        $employeesdata =  $this->EmployeeRepo->FindEmployeeDataWithOtherFeilds();

        $form = $this->createForm(EmployeesFormType::class,$employeedata);
        $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
         $this->em->flush();
          return $this->redirectToRoute('createemployee');
     
      }
        return $this->render('employees/AddEmployee.html.twig',[
        'form' => $form->createView(),
        'employee_data' => $employeesdata, 
       ]);
    }
}
