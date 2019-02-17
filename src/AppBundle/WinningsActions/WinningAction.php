<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 17.02.19
 * Time: 12:48
 */


namespace AppBundle\WinningsActions;


use AppBundle\Entity\Winning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WinningAction extends Controller
{
    public function summingWinnings($winnings)
    {
        $total = 0;
        foreach ($winnings as $win)
        {
            $total += $win->getWinItem();//sum all user winnings
        }
        return $total;
    }

    public function moneyToBankCommandFor($id)
    {
        return "hello $id";
    }
}