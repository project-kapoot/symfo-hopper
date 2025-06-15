<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Quizz;
use App\Form\InfoGeneralesFormType;

// use App\Form\InfoGeneralesFormType;

final class CreateQuizzController extends AbstractController
{
    #[Route('/create-quizz', name: 'app_create_quizz')]
    public function index(): Response
    {
        $quizz = new Quizz();
        $InfoGeneralesForm = $this->createForm(InfoGeneralesFormType::class, $quizz);
      

        return $this->render('create-quizz/create-quizz.html.twig', [
            'controller_name' => 'CreateQuizzController',
            'infoform' => $InfoGeneralesForm
        ]);
    }
}
