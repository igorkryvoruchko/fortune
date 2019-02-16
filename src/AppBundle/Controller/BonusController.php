<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loyalty;
use AppBundle\Entity\Winning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BonusController extends Controller
{
    /**
     * @Route("/bonustoloyalty", name="bonustoloyalty")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function bonusToLoyaltyAction()
    {
        $userId = $this->getUser()->getId(); //get user id
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findSomeWinnings($userId, "bonus"); //get all user money winnings
        $totalBonus = 0;
        foreach ($winnings as $win)
        {
            $totalBonus += $win->getWinItem();//sum all user money winnings
            $entityManager = $this->getDoctrine()->getManager();
            $win = $entityManager->getRepository(Winning::class)->find($win->getId());
            $win->setStatus(false);
            $entityManager->flush(); //update column status to false
        }
        $entityManager = $this->getDoctrine()->getManager();
        $loyalty = new Loyalty();
        $loyalty->setUserId($userId);
        $loyalty->setLoyaltyPoints(intdiv($totalBonus, 10));
        $entityManager->persist($loyalty);
        $entityManager->flush();// create new loyalty

        return $this->redirectToRoute('homepage');
    }

}
