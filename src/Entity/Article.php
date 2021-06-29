<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article {
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
  private $titre;
  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   */
  private $contenu;
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
  public function getTitre()
  {
    return $this->titre;
  }
  /**
   * @param mixed $titre
   */
  public function setTitre($titre)
  {
    $this->titre = $titre;
  }
  /**
   * @return mixed
   */
  public function getContenu()
  {
    return $this->contenu;
  }
  /**
   * @param mixed $contenu
   */
  public function setContenu($contenu)
  {
    $this->contenu = $contenu;
  }
}
