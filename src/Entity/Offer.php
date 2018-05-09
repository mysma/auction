<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
  const TYPE_BUY = "buy";
  const TYPE_AUCTION = "auction";
  const TYPE_BID = "bid";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2, precision=10, nullable=true)
     * @Assert\NotBlank(
     *  message="Cena nie może być pusta"
     *)
     * @Assert\GreaterThan(
     *  value="0",
     *  message="Cena musi być większa od 0"
     *)
     *
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $update_at;

    /**
     * @var Auction
     *
     * @ORM\ManyToOne(targetEntity="Auction", inversedBy="offers")
     *
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
    */
    private $auction;

    public function getId()
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function setAuction(Auction $auction)
    {
      $this->auction = $auction;
      return $this;
    }
    public function getAuction()
    {
      return $this->auction;
    }
}
