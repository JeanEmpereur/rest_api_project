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
    try{
      $repository = $this->getDoctrine()->getRepository(User::class);
      $users = $repository->findall();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'Entity User not found'], Response::HTTP_NOT_FOUND));
    }
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
    try {
      return $this->handleView($this->view($user, Response::HTTP_OK));
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'user not found'], Response::HTTP_NOT_FOUND));
    }
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
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans l\'ajout d\'un user'], Response::HTTP_NOT_IMPLEMENTED));
      }
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
      try{
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
      } catch (\Exception $exception) {
        return $this->handleView($this->view(['status' => 'erreur dans la modification'], Response::HTTP_NOT_MODIFIED));
      }
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

      return $this->handleView($this->view($user, Response::HTTP_OK));
    };
    return $this->handleView($this->view(['status' => 'the user is not marches'], Response::HTTP_NOT_ACCEPTABLE));
  }
  /**
   * Delete User.
   * @Rest\Delete("/user/{user}")
   *
   * @param User $user
   *
   * @return JsonResponse
   */
  public function deletePanier(User $user)
  {

    if (false === !!$user) {
      return $this->handleView($this->view(['status' => 'not ok'], Response::HTTP_NOT_FOUND));
    }
    try {
      $em = $this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();
    } catch (\Exception $exception) {
      return $this->handleView($this->view(['status' => 'erreur dans la suppression'], Response::HTTP_NOT_MODIFIED));
    }

    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
   }
   /**
    * Home page.
    * @Rest\Get("/users/random")
    *
    * @return Response
    */
   public function getRandomUsers()
    {
       $em = $this->getDoctrine()->getManager();
       $repo = $em->getRepository(Users::class);
       $quantity = 5;
 
       $users = $repo->findAll();
       shuffle($users);
       $users = array_slice($users, 0, $quantity);
 
       return $this->handleView($this->view($users), Response::HTTP_OK);
     }

     

}
