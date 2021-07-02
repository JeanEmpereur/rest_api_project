<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
/**
 * Article controller.
 * @Route("/api", name="api_")
 */
class ArticleController extends AbstractFOSRestController
{
  /**
   * Lists all Articles.
   * @Rest\Get("/articles")
   *
   * @return Response
   */
  public function getArticleAction()
  {
    try {
      $repository = $this->getDoctrine()->getRepository(Article::class);
      $articles = $repository->findall();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'Entity article not found'], Response::HTTP_NOT_FOUND));
    }
    return $this->handleView($this->view($articles, Response::HTTP_OK));
  }
  /**
   * Get one article.
   * @Rest\Get("/article/{article}")
   *
   * @param Article $article
   * 
   * @return Response
   */
   public function getArticlebyID(Article $article)
   {
    try {
      return $this->handleView($this->view($article, Response::HTTP_OK));
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'article not found'], Response::HTTP_NOT_FOUND));
    }
   }
  /**
   * Create Article.
   * @Rest\Post("/article")
   *
   * @return Response
   */
  public function postArticleAction(Request $request)
  {
    $article = new Article();
    $form = $this->createForm(ArticleType::class, $article);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans l\'ajout d\'un article'], Response::HTTP_NOT_IMPLEMENTED));
      }
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
  }
  /**
   * Update Article.
   * @Rest\Put("/article/{article}")
   *
   * @param Article $article
   * 
   * @return Response
   */
  public function putArticleAction(Request $request, Article $article)
  {
    $form = $this->createForm(ArticleType::class, $article);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans la modification'], Response::HTTP_NOT_MODIFIED));
      }
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form));
  }
  /**
   * Delete Article.
   * @Rest\Delete("/article/{article}")
   *
   * @param Article $article
   *
   * @return JsonResponse
   */
  public function deletePanier(Article $article)
  {

    if (false === !!$article) {
      return $this->handleView($this->view(['status' => ''], Response::HTTP_NOT_FOUND));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($article);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression'], Response::HTTP_NOT_MODIFIED));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
