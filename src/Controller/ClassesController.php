<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\Users;
use App\Form\ClassFormType;
use App\Repository\ClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ClassesController extends AbstractController
{
    private $classRepo;
    private $em;

    public function __construct(ClassesRepository $classRepo, EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->classRepo= $classRepo;
      
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

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
      $form = $this->createForm(ClassFormType::class);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $newClass = $form->getData();
        $this->em->persist($newClass);
        $this->em->flush();
        return $this->redirectToRoute('create');
      }

       $classesdata =  $this->classRepo->FindClassesByStudentCount();

       return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView(),
        'class_data' => $classesdata,
       ]);

    }

   #[Route('/deletedata/{id}', name: 'deletedata')]
    public function DeleteClass($id)
    {
        $classdata =  $this->classRepo->find($id);

        $classesdata =  $this->classRepo->FindClassesByStudentCount();

        $this->classRepo->remove($classdata);
        $this->em->flush();
        return $this->redirectToRoute('create');
        
        $form = $this->createForm(ClassFormType::class);

        return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView(),
        'class_data' => $classesdata,

       ]);
    }

    #[Route('/updatedata/{id}',name:'updatedata')]
    public function UpdateClass($id,Request $request)
    {
        $classdata =  $this->classRepo->find($id);
        $classesdata =  $this->classRepo->FindClassesByStudentCount();
        $form = $this->createForm(ClassFormType::class,$classdata);
        $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
         $classdata->setName($form->get('Name')->getdata());
         $this->em->flush();
          return $this->redirectToRoute('create');
     
      }
        return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView(),
        'class_data' => $classesdata, 
       ]);
    }
}
