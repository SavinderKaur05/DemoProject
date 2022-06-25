<?php



namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Students;
use App\Entity\Users;
use App\Form\StudentsFormType;
use App\Repository\StudentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class StudentsController extends AbstractController
{
     private $StudentRepo;
     private $em;

    public function __construct(StudentsRepository $StudentRepo, EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->StudentRepo= $StudentRepo;
      
    }

   // #[Route('/index', name: 'index')]
   //  public function index()
   //  {
   //     $form = $this->createForm(ClassFormType::class);
   //     $classesdata =  $this->classRepo->findAll();

   //     return $this->render('classes/AddClass.html.twig',[
   //      'form' => $form->createView(),
   //      'class_data' => $classesdata,
   //      ]);
   //  }

    #[Route('/createstudent', name: 'createstudent')]
    public function create(Request $request): Response
    {
      $Student = new Students();
      $form = $this->createForm(StudentsFormType::class,$Student);

      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid())
      {
        $student = $form->getData();
         $this->StudentRepo->SaveStudent($student);

          return $this->redirectToRoute('createstudent');
      }
          $studentsdata =  $this->StudentRepo->FindStudentDataWithOtherFeilds();

        return $this->render('students/AddStudent.html.twig',[
        'form' => $form->createView(),
        'student_data' => $studentsdata,
       ]);

    }

   #[Route('/deletestudentdata/{id}', name: 'deletestudentdata')]
    public function DeleteStudent($id)
    {
        $studentdata =  $this->StudentRepo->find($id);

        $studentsdata =  $this->StudentRepo->FindStudentDataWithOtherFeilds();

        $this->StudentRepo->remove($studentdata);
        $this->em->flush();
        return $this->redirectToRoute('createstudent');
        
        $form = $this->createForm(StudentsFormType::class);

        return $this->render('students/AddStudent.html.twig',[
        'form' => $form->createView(),
        'student_data' => $studentsdata,

       ]);
    }

    #[Route('/updatestudentdata/{id}',name:'updatestudentdata')]
    public function UpdateStudent($id,Request $request)
    {
        $studentdata =  $this->StudentRepo->find($id);
        
        $studentsdata =  $this->StudentRepo->FindStudentDataWithOtherFeilds();

        $form = $this->createForm(StudentsFormType::class,$studentdata);
        $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
         $studentdata->setAdmissionNumber($form->get('Admission_Number')->getdata());
         $this->em->flush();
          return $this->redirectToRoute('createstudent');
     
      }
        return $this->render('students/AddStudent.html.twig',[
        'form' => $form->createView(),
        'student_data' => $studentsdata, 
       ]);
    }
}
