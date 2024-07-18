<?php

namespace App\Controller;


use App\Entity\Animal;
use OpenApi\Annotations as OA;
use App\Entity\RapportVeterinaire;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RapportVeterinaireRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/rapport', name: 'app_rapport_')]
class RapportController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    , private RapportVeterinaireRepository $repository
    , private AnimalRepository $animal_repo
    , private SerializerInterface $serializer
    , private UrlGeneratorInterface $urlGenerator

    )
    {
    }
    
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id ,RapportVeterinaireRepository $repository ,EntityManagerInterface $entityManager,Request $request): JsonResponse
    {
        
        $rapport = $this->repository->findOneBy(['id' => $id]);
        if ($rapport) {
            $animalId = $rapport->getAnimalId()->getId(); // assuming getAnimalId() returns the Animal entity
            $responseData = [
                'date' => $rapport->getDate(),
                'detail' => $rapport->getDetail(),
                'nom' => $rapport->getNom(),
                'animal_id' => $animalId,
            ];
            return new JsonResponse($responseData, Response::HTTP_OK, []);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
  
    
  
      #[Route('/new', name: 'new', methods:'POST')]
      public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $rapport = new RapportVeterinaire();
        $rapport->setDate(new \DateTime());
        $rapport->setAnimalId($entityManager->getRepository(Animal::class)->find($data['animal_id']));
        $rapport->setDetail($data['detail']);
        $rapport->setNom($data['nom']);

        $entityManager->persist($rapport);
        $entityManager->flush();

        $jsonRapport = $serializer->serialize($rapport, 'json');

        return new Response($jsonRapport, 201);
    }
  
     
  
  
    
      
   
}
