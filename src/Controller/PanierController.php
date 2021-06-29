<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Form\PanierType;
/**
 * Product controller.
 * @Route("/api", name="api_")
 */
class PanierController extends AbstractFOSRestController
{
    /**
     * Lists all Panier.
     * @Rest\Get("/panier")
     *
     * @return Response
     */
    public function panier() {
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        return $this->handleView($this->view($panier));
    }
    /**
     * Get one product in panier.
     * @Rest\Get("/panier/{panier}")
     * 
     * @param Panier $panier
     *
     * @return Response
    */
    public function getone(Panier $panier)
    {
        return $this->handleView($this->view($panier));
    }
    /**
     * Add one product in Panier.
     * @Rest\Post("/panier")
     *
     * @return Response
     */
    public function addPanier(Request $request) {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $panier = $form->getData();
            $panier->setDateAjout(new \DateTime());
            $panier->setEtat(True);
            $em->persist($panier);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
    /**
      * Delete Panier.
      * @Rest\Delete("/panier/{panier}")
      *
      * @param Panier $panier
      *
      * @return JsonResponse
    */
     public function deletePanier(Panier $panier) {

         if (false === !!$panier) {
            return $this->handleView($this->view(['status' => 'not ok']));
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($panier);
            $em->flush();
        } catch (\Exception $exception) {
                return $this->handleView($this->view(['status' => 'erreur dans la suppression']));
        }

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }
}
