<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="User")
 */
class User {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank()
   *
   */
  private $username;
  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   *
   */
  private $password;
  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * @return mixed
   */
  public function getUsername()
  {
    return $this->username;
  }
  /**
   * @param mixed $username
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }
  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }
  /**
   * @param mixed $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }
}
