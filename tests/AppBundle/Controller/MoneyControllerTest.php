<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 16.02.19
 * Time: 15:01
 */

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller;

class MoneyControllerTest extends TestCase
{
    public function testMoneyToLoyaltyAction()
    {
        $moneyController = new Controller\MoneyController();
        $moneyController->moneyToLoyaltyAction();
    }
}