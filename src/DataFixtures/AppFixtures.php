<?php

namespace App\DataFixtures;

use App\Factory\UserTestFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserTestFactory::createOne(['email' => 'vergueiro.steven@gm.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'aaa']);
        UserTestFactory::createMany(100);


        $manager->flush();
    }
}