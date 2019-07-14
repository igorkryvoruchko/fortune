<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loyalty;
use AppBundle\Entity\Prizes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Winning;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction(Request $request)
    {
        $userId = $this->getUser()->getId();// get user id
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findAllWinnings($userId); // find all user winnings
        $loyalty = $this->getDoctrine()->getRepository(Loyalty::class)->findBy(["userId" => $userId]);//find all loyalty points
        $totalLoyalty = 0;
        foreach ($loyalty as $loyaltyPoints) {
            $totalLoyalty += $loyaltyPoints->getLoyaltyPoints();
        }
        $totalMoney = 0;
        $totalBonus = 0;
        $totalPrize = "";
        foreach ($winnings as $win)
        {
            switch ($win->getWinCategory()) //sort winnings
            {
                case "money":
                    $totalMoney += $win->getWinItem();
                    break;
                case "bonus":
                    $totalBonus += $win->getWinItem();
                    break;
                case "prize":
                    $totalPrize .= " ".$win->getWinItem();
                    break;
            }
        }

        $prizes = $this->getDoctrine()->getRepository(Prizes::class)->findAll();/*["phone", "car", "boeing-777"]; */// available prizes
        //var_dump($prizes);die();
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:main.html.twig', array(
            "prizes" => $prizes, "totalMoney" => $totalMoney, "totalBonus" => $totalBonus, "totalPrize" => $totalPrize, "totalLoyalty" => $totalLoyalty
        ));
    }


    public function winAction(Request $request) // this route for ajax requests, when user some win
    {
        if($request->request->get('userId')){
            $entityManager = $this->getDoctrine()->getManager();
            $winning = new Winning();
            $winning->setUserId($request->request->get('userId'));
            $winning->setWinCategory($request->request->get('category'));
            $winning->setWinItem($request->request->get('item'));
            $winning->setDateTime(date("Y-m-d H:i:s"));

            $entityManager->persist($winning);
            $entityManager->flush();// create new winning

            return new JsonResponse("Winnings added successfully"); // add message to console.log
        }

    }
}
