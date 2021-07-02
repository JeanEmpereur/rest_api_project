<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Config\Framework\RateLimiter\LimiterConfig\RateConfig;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PetsRepository")
 * @ORM\Table(name="Pets")
 */
class Pets {
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
  private $name;
  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   *
   */
  private $description;
  /**
   * @ORM\Column(type="boolean")
   * @Assert\NotBlank()
   */
  private $adopter;
  /**
   * @ORM\Column(type="integer")
   * @Assert\NotBlank()
   *
   */
  private $poids;
  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank()
   *
   */
  private $race;
  /**
   * @ORM\Column(type="integer")
   * @Assert\NotBlank()
   *
   */
  private $age;
  /**
   * @ORM\Column(type="datetime", nullable=true)
   *
   */
  private $date;
  /**
   * @ORM\ManyToOne(targetEntity=user::class)
   * @ORM\JoinColumn(nullable=true)
   */
  private $user;
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
  /**
   * @return mixed
   */
  public function getAdopter()
  {
    return $this->adopter;
  }
  /**
   * @param mixed $description
   */
  public function setAdopter($adopter)
  {
    $this->adopter = $adopter;
  }
  /**
   * @return mixed
   */
   public function getRace()
   {
     return $this->race;
   }
   /**
    * @param mixed $race
    */
   public function setRace($race)
   {
     $this->race = $race;
   }
   /**
   * @return mixed
   */
   public function getAge()
   {
     return $this->age;
   }
   /**
    * @param mixed $age
    */
   public function setAge($age)
   {
     $this->age = $age;
   }
   /**
   * @return mixed
   */
   public function getPoids()
   {
     return $this->poids;
   }
   /**
    * @param mixed $poids
    */
   public function setPoids($poids)
   {
     $this->poids = $poids;
   }
  /**
   * @return mixed
   */
  public function getDate()
  {
    return $this->date;
  }
  /**
   * @param mixed $date
   */
  public function setDate($date)
  {
    $this->date = $date;
  }
  /**
   * @return User
   */
  public function getUser()
  {
    return $this->user;
  }
  /**
   * @param User $user
   */
  public function setUser($user)
  {
    $this->user = $user;

    return $this;
  }
}
