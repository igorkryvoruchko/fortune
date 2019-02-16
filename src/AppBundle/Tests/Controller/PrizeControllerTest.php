<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PrizeControllerTest extends WebTestCase
{
    public function testDontneedprize()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DontNeedPrize');
    }

}
