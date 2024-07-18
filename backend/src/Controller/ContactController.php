<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ContactController extends AbstractController
{
    #[Route('/api/profile/contact', name: 'app_contact' , methods: ['POST'])]
    public function index(MailerInterface $mailer, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Get user data
        $titre = $data['titre'];
        $userEmail = $data['email'];
        $message = $data['message'];

        // Get admin email
        $adminEmail = 'alexandrebrunet460@gmail.com';
        
        // Create email
        $email = (new TemplatedEmail())
            ->from($adminEmail)
            ->to($adminEmail)
            ->replyTo('toto@gmail.com')
            ->subject("Message provenant d'un utilisateur du site easywebjob")
            ->htmlTemplate("contact/email.html.twig")
            ->context([
                "titre" => $titre,
                "message" => $message,
                "userEmail" => $userEmail,
            ]);

        // Send email
        $mailer->send($email);

        // Return success response
        return new JsonResponse(['message' => 'Email sent successfully']);
    }

}

