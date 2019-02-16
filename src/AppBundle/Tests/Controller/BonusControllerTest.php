<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BonusControllerTest extends WebTestCase
{
    public function testBonustoloyalty()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bonusToLoyalty');
    }

}
