<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Quizz;
use App\Entity\Question;
use App\Entity\Answer;
use App\Form\InfoGeneralesFormType;
use App\Form\CreateQuestionFormType;
use Doctrine\ORM\EntityManagerInterface;

final class CreateQuizzController extends AbstractController
{
    #[Route('/create-quizz', name: 'app_create_quizz')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
       
        $quizz = new Quizz();
        $InfoGeneralesForm = $this->createForm(InfoGeneralesFormType::class, $quizz);
        
        
        $question = new Question();
        
        // Pré-créer les réponses vides
        for ($i = 0; $i < 4; $i++) {
            $answer = new Answer();
            $question->addAnswer($answer);
        }
        
        $createQuestionForm = $this->createForm(CreateQuestionFormType::class, $question);
        
        // TRAITEMENT DES DEUX FORMULAIRES
        $InfoGeneralesForm->handleRequest($request);
        $createQuestionForm->handleRequest($request);
        
        if ($InfoGeneralesForm->isSubmitted() && $InfoGeneralesForm->isValid()) {
            // Traitement du formulaire InfoGeneralesFormType
            $em->persist($quizz);
            // Vous pouvez ajouter un message flash ici pour confirmer la création du quizz
        }
        
        if ($createQuestionForm->isSubmitted() && $createQuestionForm->isValid()) {
            // Traitement du formulaire CreateQuestionFormType
            $question->setQuizz($quizz); // Associer la question au quizz
            $em->persist($question);
            // Vous pouvez ajouter un message flash ici pour confirmer la création de la question
        }
       
        

        return $this->render('create-quizz/create-quizz.html.twig', [
            'controller_name' => 'CreateQuizzController',
            'infoform' => $InfoGeneralesForm,
            'questionform' => $createQuestionForm 
        ]);
    }
}