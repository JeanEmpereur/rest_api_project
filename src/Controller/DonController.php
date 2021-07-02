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
    try {
      $repository = $this->getDoctrine()->getRepository(Don::class);
      $dons = $repository->findall();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'Entity Don not found'], Response::HTTP_NOT_FOUND));
    }
    return $this->handleView($this->view($dons, Response::HTTP_OK));
  }
  /**
   * Get one Don.
   * @Rest\Get("/don/{don}")
   *
   * @param Don $don
   * 
   * @return Response
   */
  public function getDonbyID(Don $don)
  {
    try {
      return $this->handleView($this->view($don, Response::HTTP_OK));
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'don not found'], Response::HTTP_NOT_FOUND));
    }
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
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($don);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans l\'ajout d\'un don'], Response::HTTP_NOT_IMPLEMENTED));
      }
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
  }
}
