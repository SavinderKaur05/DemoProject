<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsController extends AbstractController
{
    #[Route('/students', name: 'app_students')]
    public function index(): Response
    {
        return $this->render('students/AddStudent.html.twig', [
            'controller_name' => 'StudentsController',
        ]);
    }
}
