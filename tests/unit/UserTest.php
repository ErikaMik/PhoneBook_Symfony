<?php

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    public function testGetUserName()
    {
        $user = new User;

        $user->setName('Erika');

        $this->assertEquals($user->getName(), 'Erika');
    }

}
