<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
/**
 * User controller.
 * @Route("/api", name="api_")
 */
class UserController extends AbstractFOSRestController
{
  /**
   * Lists all Users.
   * @Rest\Get("/users")
   *
   * @return Response
   */
  public function getUserAction()
  {
    $repository = $this->getDoctrine()->getRepository(User::class);
    $users = $repository->findall();
    return $this->handleView($this->view($users));
  }
  /**
   * Get one pet.
   * @Rest\Get("/user/{user}")
   *
   * @param User $user
   * 
   * @return Response
   */
  public function getUserbyID(User $user)
  {
    return $this->handleView($this->view($user));
  }
  /**
   * Create User.
   * @Rest\Post("/user")
   *
   * @return Response
   */
  public function postUserAction(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
  /**
   * Login
   * @Rest\Post("/login")
   * 
   * @return Response
   */
  public function login(Request $request)
  {
    $data = json_decode($request->getContent(), true);
  }
}
