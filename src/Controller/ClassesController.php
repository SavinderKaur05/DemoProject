<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassFormType;
use App\Repository\ClassesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    
    
    #[Route('/create', name: 'Create_Class')]
    public function create(Request $request): Response
    {
       // $em = EntityManagerInterface();
       $class = new Classes();
       $form = $this->createForm(ClassFormType::class,$class);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $newClass= $form->getData();
        dd($newClass);
        exit;
      }

       return $this->render('classes/AddClass.html.twig',[
        'form' => $form->createView()
       ]);
    }
}
