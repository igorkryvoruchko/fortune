<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Winning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PrizeController extends Controller
{
    /**
     * @Route("/dontneedprize", name="dontneedprize")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function DontNeedPrizeAction()
    {
        $userId = $this->getUser()->getId(); //get user id
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findSomeWinnings($userId, "prize"); //get all user winnings
        foreach ($winnings as $win) {
            $entityManager = $this->getDoctrine()->getManager();
            $win = $entityManager->getRepository(Winning::class)->find($win->getId());
            $win->setStatus(false);
            $entityManager->flush(); //update column status to false
        }
        return $this->redirectToRoute('homepage');
    }

}
