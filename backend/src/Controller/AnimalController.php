<?php

namespace App\Controller;

use Exception;
use App\Entity\Animal;
use App\Entity\Habitat;
use OpenApi\Annotations as OA;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/animal', name: 'app_animal_')]
class AnimalController extends AbstractController
{
    public function __construct(
      private EntityManagerInterface $manager
    , private AnimalRepository $repository
    , private HabitatRepository $habitatrepo
    , private SerializerInterface $serializer
    , private UrlGeneratorInterface $urlGenerator

    )
    {
    }

     /** @OA\Get(
     *     path="/api/animal/{id}",
     *     summary="Afficher un animal par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'animal à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nom", type="string", example="Nom de l'animal"),
     *             @OA\Property(property="etat", type="string", example="bon"),
     *            
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Animal non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id ,EntityManagerInterface $entityManager,Request $request): JsonResponse
    {
        $animal = $this->repository->findOneBy(['id' => $id]);
        if ($animal) {
            $responseData = [
                'prenom' => $animal->getPrenom(),
                'etat' => $animal->getEtat(),
                'click' => $animal->getClick(),
                'race' => $animal->getRace(),
            ];
            return new JsonResponse($responseData, Response::HTTP_OK, []);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /** @OA\Post(
     *     path="/api/animal/new",
     *     summary="Ajouter un animal  par ID",
     *     
     * )
     */
    #[Route('/new', name: 'new', methods:'POST')]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $animal = new Animal();
        $animal->setPrenom($data['prenom']);
        $animal->setEtat($data['etat']);
        $animal->setHabitatId($entityManager->getRepository(Habitat::class)->find($data['habitat_id']));
        $animal->setRace($data['race']);

        $entityManager->persist($animal);
        $entityManager->flush();

        $jsonAnimal = $serializer->serialize($animal, 'json');

        return new Response($jsonAnimal, 201);
    }
   /** @OA\Put(
         *     path="/api/animal/{id}",
         *     summary="Modifier un animal par ID",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID du animal à modifier",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         description="Nouvelles données du restaurant à mettre à jour",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="nom", type="string", example="Nouveau nom de l'animal"),
         *             @OA\Property(property="etat", type="string", example="Ajouter un état"),
         *             
         *             @OA\Property(property="race", type="string", example="Nouvelle race de l'animal"),
         * 
         *         )
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="service modifié avec succès"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="servie non trouvé"
         *     )
         * )
         */
   #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id ,Request $request): JsonResponse
    {
        $service = $this->repository->findOneBy(['id' => $id]);
        if ($service) {
            $service = $this->serializer->deserialize(
                $request->getContent(),
                Animal::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $service]
            );
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    /** @OA\Delete(
     *     path="/api/animal/{id}",
     *     summary="Supprimer un animal par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du animal à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="animal supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="animal non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $service = $this->repository->findOneBy(['id' => $id]);
        if ($service) {
            $this->manager->remove($service);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}/click', name: 'animal_click', methods: ['POST'])]
    public function click($id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $animal = $entityManager->getRepository(Animal::class)->find($id);
        if (!$animal) {
            throw $this->createNotFoundException();
        }

        $animal->incrementClick();
        $entityManager->flush();

        return new JsonResponse(['click' => $animal->getClick()]);
    }
   
}
