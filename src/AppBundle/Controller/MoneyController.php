<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loyalty;
use AppBundle\Entity\Winning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Unirest;

class MoneyController extends Controller
{
    /**
     * @Route("/moneytobank/{code}", name="moneytobank")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function moneyToBankAction($code)
    {
        $userId = $this->getUser()->getId();//get user id
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findAllWinnings($userId);//get all user winnings
        $totalMoney = 0;

        foreach ($winnings as $win) {
            switch ($win->getWinCategory()) {
                case "money":
                    $totalMoney += $win->getWinItem();//sum all user money winnings
                    break;
            }
        }
        $headers = array('Accept' => 'application/json');
        $query = array('code' => $code, 'sum' => $totalMoney);
                                                /*https://citybank/api*/
        $response = Unirest\Request::get('https://jsonplaceholder.typicode.com/todos/',$headers, $query); //send http request to the bank with number of account and sum
        if($response->code == 200) {
            foreach ($winnings as $win) {
                switch ($win->getWinCategory()) {
                    case "money":
                        $entityManager = $this->getDoctrine()->getManager();
                        $win = $entityManager->getRepository(Winning::class)->find($win->getId());
                        $win->setStatus(false);
                        $entityManager->flush(); // if transaction return code = 200, update column status to false
                        break;
                }
            }
            return $this->redirectToRoute('homepage');
        } else {
            return new Response("Error with your account!!!"); // if transaction return code != 200 return error message
        }
    }

    /**
     * @Route("/moneytoloyalty/", name="moneytoloyalty")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function moneyToLoyaltyAction()
    {
        $userId = $this->getUser()->getId(); //get user id
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findAllWinnings($userId); //get all user winnings
        $totalMoney = 0;
        foreach ($winnings as $win) {
            switch ($win->getWinCategory()) {
                case "money":
                    $totalMoney += $win->getWinItem();//sum all user money winnings
                    $entityManager = $this->getDoctrine()->getManager();
                    $win = $entityManager->getRepository(Winning::class)->find($win->getId());
                    $win->setStatus(false);
                    $entityManager->flush(); //update column status to false
                    break;
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $loyalty = new Loyalty();
        $loyalty->setUserId($userId);
        $loyalty->setLoyaltyPoints($totalMoney);

        $entityManager->persist($loyalty);
        $entityManager->flush();// create new loyalty

        return $this->redirectToRoute('homepage');
    }
}
