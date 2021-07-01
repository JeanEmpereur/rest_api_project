<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Don;
use App\Form\DonType;
/**
 * Don controller.
 * @Route("/api", name="api_")
 */
class DonController extends AbstractFOSRestController
{
  /**
   * Lists all Dons.
   * @Rest\Get("/dons")
   *
   * @return Response
   */
  public function getDonAction()
  {
    $repository = $this->getDoctrine()->getRepository(Don::class);
    $dons = $repository->findall();
    return $this->handleView($this->view($dons));
  }
  /**
   * Get one pet.
   * @Rest\Get("/don/{don}")
   *
   * @param Don $don
   * 
   * @return Response
   */
  public function getDonbyID(Don $don)
  {
    return $this->handleView($this->view($don));
  }
  /**
   * Create Don.
   * @Rest\Post("/don")
   *
   * @return Response
   */
  public function postDonAction(Request $request)
  {
    $don = new Don();
    $form = $this->createForm(DonType::class, $don);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($don);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
  /**
   * Delete Don.
   * @Rest\Delete("/don/{don}")
   *
   * @param Don $don
   *
   * @return JsonResponse
   */
  public function deletePanier(Don $don)
  {

    if (false === !!$don) {
      return $this->handleView($this->view(['status' => 'not ok']));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($don);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression']));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
