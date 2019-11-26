<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex(){
        $client = static::createClient(); // Create client.
        $crawler = $client->request('GET', '/'); // Get default content.

        // The HTML response code is 200.
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Asserts contains the specified text.
        $this->assertContains(
            'Application System',
            $client->getResponse()->getContent()
        );

        // Assert that there are exactly 1 h2 tags on the page
        $this->assertCount(1, $crawler->filter('h1'));

        // Asserts there are greater than 2 "<a>" tags - will fail.
        $this->assertGreaterThan(
            2,
            $crawler->filter('a')->count()
        );
    }
}