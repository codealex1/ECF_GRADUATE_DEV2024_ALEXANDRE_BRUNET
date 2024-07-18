<?php

namespace App\Controller;

use App\Entity\Service;
use OpenApi\Annotations as OA;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/service', name: 'app_service_')]
class ServiceController extends AbstractController
{
    public function __construct(
      private EntityManagerInterface $manager
    , private ServiceRepository $repository
    , private SerializerInterface $serializer
    , private UrlGeneratorInterface $urlGenerator

    )
    {
    }

     /** @OA\Get(
     *     path="/api/service/{id}",
     *     summary="Afficher un service par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du service à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nom du service"),
     *             @OA\Property(property="description", type="string", example="services"),
     *             @OA\Property(property="heure_ouverture", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $service = $this->repository->findOneBy(['id' => $id]);
        if ($service) {
            $responseData = $this->serializer->serialize($service, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/new', name: 'new', methods:'POST')]
    public function new(Request $request): Response{
        
        $service = $this->serializer->deserialize($request->getContent(), Service::class, 'json');

        
       

        $this->manager->persist($service);

        $this->manager->flush();

        $responseData = $this->serializer->serialize($service, 'json');
        $location = $this->urlGenerator->generate(
            'home',
            ['id' => $service->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
   }

   /** @OA\Put(
         *     path="/api/service/{id}",
         *     summary="Modifier un service par ID",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID du service à modifier",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         description="Nouvelles données du restaurant à mettre à jour",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="name", type="string", example="Nouveau nom du service"),
         *             @OA\Property(property="description", type="string", example="Nouvelle description du service"),
         *             @OA\Property(property="heure_ouverture", type="string", format="date-time"),
         *             @OA\Property(property="heure_fermeture", type="string", format="date-time")
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
                Service::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $service]
            );
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    /** @OA\Delete(
     *     path="/api/service/{id}",
     *     summary="Supprimer un service par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du service à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="service supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="service non trouvé"
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
   
}
