<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="Product")
 */
class Product {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
    * @ORM\Column(type="integer")
    * @Assert\NotBlank()
    */
  private $prix;
  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank()
   *
   */
  private $name;
  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   */
  private $description;
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
  public function getPrix()
  {
    return $this->name;
  }
  /**
   * @param mixed $prix
   */
  public function setPrix($prix)
  {
    $this->prix = $prix;
  }



  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param mixed $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * @return mixed
   */
  public function getDescription()
  {
    return $this->description;
  }
  /**
   * @param mixed $description
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }
}
