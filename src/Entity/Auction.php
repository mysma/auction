<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuctionRepository")
 */
class Auction
{
    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finished";
    const STATUS_CANCELLED = "cancelled";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *  message="Tytuł nie może być pusty"
     * )
     * @Assert\Length(
     *    min=3,
     *    max=255,
     *    minMessage="Tytuł nie może być krótszy niż 3 znaki",
     *    maxMessage="Tytuł nie może być dłuższy niż 255znaków"
     *)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *  message="Opis nie może być pusty"
     *)
     * @Assert\Length(
     *  min=10,
     * minMessage="Opis nie może być króttszy niż 10 znaków"
     *)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10)
     * @Assert\NotBlank(
     *  message="Cena nie może być pusta"
     *)
     * @Assert\GreaterThan(
     *  value="0",
     *  message="Cena musi być większa od 0"
     *)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="starting_price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *  message="Cena wywoławcza nie może być pusta"
     *)
     * @Assert\GreaterThan(
     *  value="0",
     *  message="Cena wywoławcza musi być większa od 0"
     *)
     */
    private $startingPrice;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
    */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
    */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     * @Assert\NotBlank(
     *  message="Musisz podać datę zakończenia"
     *)
     * @Assert\GreaterThan(
     *  value="+1 day",
     *  message="Aukcja nie może kończyć się za mniej niż 24h"
     *)
    */
    private $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
    */
    private $status;

    /**
    * @var Offer[]
    *
    * @ORM\OneToMany(targetEntity="Offer", mappedBy="auction")
    */
    private $offers;

    /**
     * Auction constructor.
    */
    public function _construct()
    {
      $this->offers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }
    /**
     * @param float $startingPrice
     *
     * @return $this
    */
    public function setStartingPrice($startingPrice)
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }
    /**
     * @return float
    */
    public function getStartingPrice()
    {
      return $this->startingPrice;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
    */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    /**
     * @return \DateTime
    */
    public function getCreatedAt()
    {
      return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
    */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * @return \DateTime
    */
    public function getUpdatedAt()
    {
      return $this->updatedAt;
    }

    /**
     * @param \DateTime $expiresAt
     *
     * @return $this
    */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
    /**
     * @return \DateTime
    */
    public function getExpiresAt()
    {
      return $this->expiresAt;
    }

    /**
     * @param string $status
     *
     * @return $this
    */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    /**
     * @return string
    */
    public function getStatus()
    {
      return $this->status;
    }

    /**
     * @return Offer[]\ArrayCollection
    */
    public function getOffers()
    {
      return $this->offers;
    }
    /**
     * @param Offer $offer
      *
      * @return $this
    */
    public function addOffer(Offer $offer)
    {
      $this->offers[] = $offer;
      return $this;
    }
}
