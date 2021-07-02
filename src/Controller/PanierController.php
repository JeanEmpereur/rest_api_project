<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\User;
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
        try {
            $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        } catch (\Exception $exception) {
            return $this->handleView($this->view(['status' => 'Entity Panier not found'], Response::HTTP_NOT_FOUND));
        }
        return $this->handleView($this->view($panier, Response::HTTP_OK));
    }
    /**
     * Lists Panier by user.
     * @Rest\Get("/panier/{user}")
     *
     * @param User $user
     * 
     * @return Response
     */
    public function panierByUser(User $user)
    {
        try {
            $panier = $this->getDoctrine()->getRepository(Panier::class)->findBy(array('user' => $user));
        } catch (\Exception $exception) {
            return $this->handleView($this->view(['status' => 'panier not found'], Response::HTTP_NOT_FOUND));
        }
        return $this->handleView($this->view($panier, Response::HTTP_OK));
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
        try {
            return $this->handleView($this->view($panier, Response::HTTP_OK));
        } catch (\Exception $exception) {
            return $this->handleView($this->view(['status' => 'panier not found'], Response::HTTP_NOT_FOUND));
        }
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
            try {
                $em = $this->getDoctrine()->getManager();
                $panier = $form->getData();
                $panier->setDateAjout(new \DateTime());
                $panier->setEtat(True);
                $em->persist($panier);
                $em->flush();
            } catch (\Exception $exception) {
                return $this->handleView($this->view(['status' => 'erreur dans l\'ajout d\'un panier'], Response::HTTP_NOT_IMPLEMENTED));
            }

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
    }
    /**
     * Update Panier.
     * @Rest\Put("/panier/{panier}")
     *
     * @param Panier $panier
     * 
     * @return Response
     */
    public function putPanierAction(Request $request, Panier $panier)
    {
        $form = $this->createForm(PanierType::class, $panier);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($panier);
                $em->flush();
            } catch (\Exception $exception) {
                return $this->handleView($this->view(['status' => 'erreur dans la modification'], Response::HTTP_NOT_MODIFIED));
            }
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form), Response::HTTP_OK);
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
            return $this->handleView($this->view(['status' => 'not ok'], Response::HTTP_NOT_FOUND));
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($panier);
            $em->flush();
        } catch (\Exception $exception) {
                return $this->handleView($this->view(['status' => 'erreur dans la suppression'], Response::HTTP_NOT_MODIFIED));
        }

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
    }
}
