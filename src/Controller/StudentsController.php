<?php



namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\Users;
use App\Form\StudentFormType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class StudentsController extends AbstractController
{
     private $StudentRepo;
     private $em;

    public function __construct(StudentRepository $StudentRepo, EntityManagerInterface $em)
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
      $form = $this->createForm(StudentFormType::class);

      $form->handleRequest($request);
       $student=new Student();

      if($form->isSubmitted() && $form->isValid())
      {
        $student->setAdmissionNumber($form->get('Admission_Number')->getData());
        $student->setClassId($form->get('classId')->getdata());
        
        $user=new Users();
        $user->setName($form->get('inputName')->getData());
        $user->setPassword($form->get('inputName')->getData().'@123');
        $user->setRole('Student');
        $user->setUserType('Student');
        $user->setUserName($form->get('inputName')->getData().'@1');
        
        // //User Created 
        $this->em->persist($user);
        $this->em->flush();

        $student->setUserId($user);

        //student Created
        $this->em->persist($student);
        $this->em->flush();


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
        
        $form = $this->createForm(StudentFormType::class);

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

        $form = $this->createForm(StudentFormType::class,$studentdata);
        $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
         $studentdata->setAdmissionNumber($form->get('Admission_Number')->getdata());
         $this->em->flush();
          return $this->redirectToRoute('createstudent');
     
      }
        return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView(),
        'student_data' => $studentsdata, 
       ]);
    }
}
