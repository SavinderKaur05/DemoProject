<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController
{
    #[Route('/employees', name: 'app_employees')]
    public function index(): Response
    {
        return $this->render('employees/AddEmployee.html.twig', [
            'controller_name' => 'EmployeesController',
        ]);
    }
}
