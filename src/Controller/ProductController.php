<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;
/**
 * Product controller.
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractFOSRestController
{
  /**
   * Lists all Products.
   * @Rest\Get("/products")
   *
   * @return Response
   */
  public function getProductAction()
  {
    $repository = $this->getDoctrine()->getRepository(Product::class);
    $products = $repository->findall();
    return $this->handleView($this->view($products));
  }
  /**
   * Get one product.
   * @Rest\Get("/products/{product}
   *
   * @param Product $product
   * 
   * @return Response
   */
   public function getProductbyID(Product $product)
   {
     return $this->handleView($this->view($product));
   }
  /**
   * Create Product.
   * @Rest\Post("/product")
   *
   * @return Response
   */
  public function postProductAction(Request $request)
  {
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
  /**
   * Delete Product.
   * @Rest\Delete("/product/{product}")
   *
   * @param Product $product
   *
   * @return JsonResponse
   */
  public function deletePanier(Product $product)
  {

    if (false === !!$product) {
      return $this->handleView($this->view(['status' => 'not ok']));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($product);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression']));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
