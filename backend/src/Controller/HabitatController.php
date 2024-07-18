<?php

namespace App\Controller;


use App\Entity\Habitat;
use OpenApi\Annotations as OA;
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


#[Route('/api/habitat', name: 'app_habitat_')]
class HabitatController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    , private HabitatRepository $repository
    , private SerializerInterface $serializer
    , private UrlGeneratorInterface $urlGenerator

    )
    {
    }
    
     /** @OA\Get(
     *     path="/api/habitat/{id}",
     *     summary="Afficher un habitat par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l' habitat à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="habitat trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nom", type="string", example="Nom de l'habitat"),
     *             @OA\Property(property="description", type="string", example=""),
     *             @OA\Property(property="commentaire_habitat", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Habitat non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
      public function show(int $id): JsonResponse
      {
          $habitat = $this->repository->findOneBy(['id' => $id]);
          if ($habitat) {
              $responseData = $this->serializer->serialize($habitat, 'json');
  
              return new JsonResponse($responseData, Response::HTTP_OK, [], true);
          }
  
          return new JsonResponse(null, Response::HTTP_NOT_FOUND);
      }
  
  
      #[Route('/new', name: 'new', methods:'POST')]
      public function new(Request $request): Response{
          
          $habitat = $this->serializer->deserialize($request->getContent(), Habitat::class, 'json');
  
          
         
  
          $this->manager->persist($habitat);
  
          $this->manager->flush();
  
          $responseData = $this->serializer->serialize($habitat, 'json');
          $location = $this->urlGenerator->generate(
              'home',
              ['id' => $habitat->getId()],
              UrlGeneratorInterface::ABSOLUTE_URL,
          );
  
          return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
      
     }
  
    /** @OA\Put(
         *     path="/api/habitat/{id}",
         *     summary="Modifier un habitat par ID",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID du habitat à modifier",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         description="Nouvelles données de l'habitat à mettre à jour",
         *         @OA\JsonContent(
         *             type="object",
         *              @OA\Property(property="nom", type="string", example="Nom de l'habitat"),
         *              @OA\Property(property="description", type="string", example=""),
         *              @OA\Property(property="commentaire_habitat", type="string", example="")
         *         )
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="habitat modifié avec succès"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="habitat non trouvé"
         *     )
         * )
         */
     #[Route('/{id}', name: 'edit', methods: 'PUT')]
      public function edit(int $id ,Request $request): JsonResponse
      {
          $habitat = $this->repository->findOneBy(['id' => $id]);
          if ($habitat) {
              $habitat = $this->serializer->deserialize(
                  $request->getContent(),
                  Habitat::class,
                  'json',
                  [AbstractNormalizer::OBJECT_TO_POPULATE => $habitat]
              );
              
              $this->manager->flush();
  
              return new JsonResponse(null, Response::HTTP_NO_CONTENT);
          }
  
          return new JsonResponse(null, Response::HTTP_NOT_FOUND);
      }
  
  
  
      /** @OA\Delete(
       *     path="/api/habitat/{id}",
       *     summary="Supprimer un habitat par ID",
       *     @OA\Parameter(
       *         name="id",
       *         in="path",
       *         required=true,
       *         description="ID du habitat à supprimer",
       *         @OA\Schema(type="integer")
       *     ),
       *     @OA\Response(
       *         response=204,
       *         description="habitat supprimé avec succès"
       *     ),
       *     @OA\Response(
       *         response=404,
       *         description="habitat non trouvé"
       *     )
       * )
       */
      #[Route('/{id}', name: 'delete', methods: 'DELETE')]
      public function delete(int $id): JsonResponse
      {
          $habitat = $this->repository->findOneBy(['id' => $id]);
          if ($habitat) {
              $this->manager->remove($habitat);
              $this->manager->flush();
  
              return new JsonResponse(null, Response::HTTP_NO_CONTENT);
          }
  
          return new JsonResponse(null, Response::HTTP_NOT_FOUND);
      }
   
}
