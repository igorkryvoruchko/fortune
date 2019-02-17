<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loyalty;
use AppBundle\Entity\User;
use AppBundle\Entity\Winning;
use AppBundle\WinningsActions\WinningAction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Unirest;

class MoneyController extends Controller
{
    /**
     * @Route("/moneytobank/", name="moneytobank")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function moneyToBankAction()
    {
        $userId = $this->getUser()->getId();//get user id
        $code = $this->getDoctrine()->getRepository(User::class)->find($userId);//get user code of bank account
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findSomeWinnings($userId, "money");//get all user money winnings
        $summingMoney = new WinningAction();
        $totalMoney = $summingMoney->summingWinnings($winnings);//summing all money user winnings
        $headers = array('Accept' => 'application/json');
        $query = array('code' => $code->getCode(), 'sum' => $totalMoney);
        $response = Unirest\Request::get('https://jsonplaceholder.typicode.com/todos/',$headers, $query); //send http request to the bank with number of account and sum
        if($response->code == 200)                  /*https://citybank/api/ */
        {
            $update = $this->get('MoneyServices'); //update all money winnings to false
            $update->setStatusFalseWinnings($winnings);
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
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findSomeWinnings($userId, "money"); //get all user money winnings
        $summingMoney = new WinningAction();
        $totalMoney = $summingMoney->summingWinnings($winnings);//summing all money user winnings
        $update = $this->get('MoneyServices');
        $update->setStatusFalseWinnings($winnings);//update all money winnings to false
        $entityManager = $this->getDoctrine()->getManager();
        $loyalty = new Loyalty();
        $loyalty->setUserId($userId);
        $loyalty->setLoyaltyPoints($totalMoney * 10);
        $entityManager->persist($loyalty);
        $entityManager->flush();// create new loyalty

        return $this->redirectToRoute('homepage');
    }


    public function moneyToBankCommandForAction($id)
    {
        $code = $this->getDoctrine()->getRepository(User::class)->find($id);//get user code of bank account
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findSomeWinnings($id, "money");//get all user money winnings
        $summingMoney = new WinningAction();
        $totalMoney = $summingMoney->summingWinnings($winnings);
        $headers = array('Accept' => 'application/json');
        $query = array('code' => $code->getCode(), 'sum' => $totalMoney);
        $response = Unirest\Request::get('https://jsonplaceholder.typicode.com/todos/',$headers, $query); //send http request to the bank with number of account and sum
        if($response->code == 200)                  /*https://citybank/api/ */
        {
            foreach ($winnings as $win)
            {
                $entityManager = $this->getDoctrine()->getManager();
                $win = $entityManager->getRepository(Winning::class)->find($win->getId());
                $win->setStatus(false);
                $entityManager->flush(); //update column status to false
            }
            return $this->redirectToRoute('homepage');
        } else {
            return new Response("Error with your account!!!"); // if transaction return code != 200 return error message
        }
    }
}
