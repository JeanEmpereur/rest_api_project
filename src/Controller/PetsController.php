<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pets;
use App\Form\PetsType;
/**
 * Pets controller.
 * @Route("/api", name="api_")
 */
class PetsController extends AbstractFOSRestController
{
  /**
   * Lists all Petss.
   * @Rest\Get("/pets")
   *
   * @return Response
   */
  public function getPets()
  {
    try {
      $repository = $this->getDoctrine()->getRepository(Pets::class);
      $pets = $repository->findall();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'Entity Pets not found'], Response::HTTP_NOT_FOUND));
    }
    return $this->handleView($this->view($pets, Response::HTTP_OK));
  }
  /**
   * Get one pet.
   * @Rest\Get("/pet/{pet}")
   *
   * @param Pets $pet
   *
   * @return Response
   */
   public function getPetbyID(Pets $pet)
   {
    try {
      return $this->handleView($this->view($pet, Response::HTTP_OK));
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'pet not found'], Response::HTTP_NOT_FOUND));
    }
   }
  /**
   * Create Pets.
   * @Rest\Post("/pet")
   *
   * @return Response
   */
  public function postPetsAction(Request $request)
  {
    $pet = new Pets();
    $form = $this->createForm(PetsType::class, $pet);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($pet);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
  }
  /**
   * Update Pets.
   * @Rest\Put("/pet/{pet}")
   *
   * @param Pets $pet
   *
   * @return Response
   */
   public function putPetsAction(Request $request, Pets $pet)
   {
    $form = $this->createForm(PetsType::class, $pet);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($pet);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form, Response::HTTP_OK));
   }
  /**
   * Delete Pet.
   * @Rest\Delete("/pet/{pet}")
   *
   * @param Pets $pet
   *
   * @return JsonResponse
   */
  public function deletePanier(Pets $pet)
  {

    if (false === !!$pet) {
      return $this->handleView($this->view(['status' => 'not ok'], Response::HTTP_NOT_FOUND));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($pet);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression'], Response::HTTP_NOT_MODIFIED));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
  /**
   * Home page.
   * @Rest\Get("/pets/random")
   *
   * @return Response
   */
  public function getRandomPets()
   {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository(Pets::class);
      $quantity = 5;

      $pets = $repo->findAll();
      shuffle($pets);
      $pets = array_slice($pets, 0, $quantity);

      return $this->handleView($this->view($pets), Response::HTTP_OK);
    }
  /**
   * Home page.
   * @Rest\Get("/pets/adopte")
   *
   * @return Response
   */
  public function getAdoptePets()
  {
    $em = $this->getDoctrine()->getManager();
    $pets = $em->getRepository(Pets::class)->findBy(array("date" => "10/10/2021"));
    
    return $this->handleView($this->view($pets), Response::HTTP_OK);
  }
}
