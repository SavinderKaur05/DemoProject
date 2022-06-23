<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassFormType;
use App\Repository\ClassesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ClassesController extends AbstractController
{
    private $em;
    public function __construct(ClassesRepository $repo)
    {
       $em = $repo;
    }

    #[Route('/create', name: 'Create_Class')]
    public function create(Request $request): Response
    {
        $classes = new Classes();
      // $classes =  $this->em->findAll();

       $form = $this->createForm(ClassFormType::class,$classes);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        dd($classes);
      }

       return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView()
       ]);
    }
}
