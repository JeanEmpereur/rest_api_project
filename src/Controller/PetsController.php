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
    $repository = $this->getDoctrine()->getRepository(Pets::class);
    $pets = $repository->findall();
    return $this->handleView($this->view($pets));
  }
  /**
   * Get one pet.
   * @Rest\Get("/pets/{pet}")
   *
   * @param Pets $pet
   * 
   * @return Response
   */
   public function getPetbyID(Pets $pet)
   {
     return $this->handleView($this->view($pet));
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
    return $this->handleView($this->view($form->getErrors()));
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
      return $this->handleView($this->view(['status' => 'not ok']));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($pet);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression']));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
