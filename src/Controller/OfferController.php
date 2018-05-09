<?php

namespace App\Controller;

use App\Entity\Auction;
use App\Form\BidType;
use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends Controller
{
  /**
    * @Route("/auction/buy/{id}", name="offer_buy", methods={"POST"})
    * @param Auction $auction
    *
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
  */
  public function buy(Auction $auction)
  {
    $offer = new Offer();
    $offer
      ->setAuction($auction)
      ->setType(Offer::TYPE_BUY)
      ->setPrice($auction->getPrice());

    $auction
      ->setStatus(Auction::STATUS_FINISHED)
      ->setExpiresAt(new \DateTime());

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($auction);
    $entityManager->persist($offer);
    $entityManager->flush();

    $this->addFlash("success", "Kupiłeś przedmiot {$auction->getTitle()} za kwotę {$offer->getPrice()} zł");
    return $this->redirectToRoute("auction_details", ["id" => $auction->getID()]);
  }

  /**
   * @Route("auction/bid/{id}", name="offer_bid", methods={"POST"})
   *
   * @param Request $request
   * @param Auction $auction
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse;
  */
  public function bid(Request $request, Auction $auction)
  {
      $offer = new Offer();
      $bidForm = $this->createForm(BidType::class, $offer);

      $bidForm->handleRequest($request);
      if($bidForm->isValid())
      {
        $entityManager = $this->getDoctrine()->getManager();
        $lastOffer = $entityManager
          ->getRepository(Offer::class)
          ->findOneBy(["auction" => $auction], ["createAt" => "DESC"]);

        if(isset($lastOffer))
        {
          if($offer->getPrice() <= $lastOffer->getPrice())
          {
            $this->addFlash("error", "Twoja oferta nie może być niższa niż {$lastOffer->getPrice()} zł");
            return $this->redirectToRoute("auction_details", ["id" => $auction->getId()]);
          }
        }

        $offer
          ->setType(Offer::TYPE_BID)
          ->setAuction($auction);

        $entityManager->persist($offer);
        $entityManager->flush();
        $this->addFlash("success", "Złożyłeś ofertę na przedmiot {$auction->getTitle()} za kwotę {$offer->getPrice()} zł");
      }
      else
      {
          $this->addFlash("error", "Nie udało się wylicytować przedmiotu {$auction->getTitle()} za kwotę {$offer->getPrice()} zł");
      }
        return $this->redirectToRoute("auction_details", ["id" => $auction->getId()]);

  }
}
