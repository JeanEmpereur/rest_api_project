<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Firebase\JWT\JWT;
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
    return $this->handleView($this->view($users, Response::HTTP_OK));
  }
  /**
   * Get one user.
   * @Rest\Get("/user/{user}")
   *
   * @param User $user
   * 
   * @return Response
   */
  public function getUserbyID(User $user)
  {
    return $this->handleView($this->view($user, Response::HTTP_OK));
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
    return $this->handleView($this->view($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE));
  }
  /**
   * Update User.
   * @Rest\Put("/user/{user}")
   *
   * @param User $user
   * 
   * @return Response
   */
  public function putUserAction(Request $request, User $user)
  {
    $form = $this->createForm(UserType::class, $user);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form, Response::HTTP_OK));
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
    $username = $data['username'];
    $password = $data['password'];

    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(User::class)->findOneBy(array('username' => $username));
    if ($user->getPassword() === $password) {
      $date = new \DateTime();
      $date->add(new \DateInterval('P1D'));
      $ts = $date->getTimestamp();
      $key = "toto";
      $payload = [
        "id" => $user->getId(),
        "email" => $user->getUsername(),
        // "roles" => $user->getRole(),
        "exp" => $ts
      ];
      $jwt = JWT::encode($payload, $key);
      return $this->handleView($this->view($jwt, Response::HTTP_OK));
    };
    return $this->handleView($this->view(['status' => 'not ok'], Response::HTTP_NOT_ACCEPTABLE));
  }
}
