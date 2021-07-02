<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Product;
use App\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="Panier")
 */
class Panier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ajout;
    /**
     * @ORM\ManyToOne(targetEntity=user::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
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
    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
    /**
     * @param mixed $quantite
     */
    public function setQuantite(int $quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getDateAjout()
    {
        return $this->date_ajout;
    }
    /**
     * @param mixed $date_ajout
     */
    public function setDateAjout( $date_ajout)
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }
}
