<?php

namespace App\Controller;

use DateTime;
use App\Entity\Animal;
use App\Entity\Alimentation;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AlimentationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/alimentation', name: 'app_alimentation')]
class AlimentationController extends AbstractController
{
    public function __construct(
      private EntityManagerInterface $manager
    , private AlimentationRepository $repository
    , private AnimalRepository $animal_repo
    , private SerializerInterface $serializer
    , private UrlGeneratorInterface $urlGenerator

    )
    {
    }

    #[Route('/new', name: 'new', methods:'POST')]
      public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $alimentation = new Alimentation();
        $alimentation->setDate(new DateTime());
        $alimentation->setAnimal($entityManager->getRepository(Animal::class)->find($data['animal']));
        $alimentation->setNourriture($data['nourriture']);
        $alimentation->setQuantite($data['quantite']);

        $entityManager->persist($alimentation);
        $entityManager->flush();

        $jsonAli = $serializer->serialize($alimentation, 'json');

        return new Response($jsonAli, 201);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id ,AlimentationRepository $repository ,EntityManagerInterface $entityManager,Request $request): JsonResponse
    {
        
        $alimentation = $this->repository->findOneBy(['id' => $id]);
        if ($alimentation) {
            $animalId = $alimentation->getAnimal()->getId(); // assuming getAnimalId() returns the Animal entity
            $responseData = [
                'nourriture' => $alimentation->getNourriture(),
                'quantite' => $alimentation->getQuantite(),
                'date' => $alimentation->getDate(),
                'animal_id' => $animalId,
            ];
            return new JsonResponse($responseData, Response::HTTP_OK, []);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
