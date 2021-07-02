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
    try{
      $repository = $this->getDoctrine()->getRepository(Product::class);
      $products = $repository->findall();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'Entity Product not found'], Response::HTTP_NOT_FOUND));
    }
    return $this->handleView($this->view($products, Response::HTTP_OK));
  }
  /**
   * Get one product.
   * @Rest\Get("/product/{product}")
   *
   * @param Product $product
   *
   * @return Response
   */
  public function getProductbyID(Product $product)
  {
    try {
      return $this->handleView($this->view($product, Response::HTTP_OK));
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'product not found'], Response::HTTP_NOT_FOUND));
    }
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
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans l\'ajout d\'un product'], Response::HTTP_NOT_IMPLEMENTED));
      }
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
  }
  /**
   * Update Product.
   * @Rest\Put("/product/{product}")
   *
   * @param Product $product
   *
   * @return Response
   */
  public function putProductAction(Request $request, Product $product)
  {
    $form = $this->createForm(ProductType::class, $product);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans la modification'], Response::HTTP_NOT_MODIFIED));
      }
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form), Response::HTTP_OK);
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
      return $this->handleView($this->view(['status' => 'not ok'], Response::HTTP_NOT_FOUND));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($product);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression'], Response::HTTP_NOT_MODIFIED));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
  /**
   * Get 5 Product Random
   * @Rest\Get("/products/random")
   *
   * @return Response
   */
  public function getRandomProduct()
  {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository(Product::class);
    $quantity = 5;

    $products = $repo->findAll();
    shuffle($products);
    $products = array_slice($products, 0, $quantity);

    return $this->handleView($this->view($products), Response::HTTP_OK);
  }
}
