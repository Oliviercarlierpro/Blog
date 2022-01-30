<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Olivier');
$user->setPassword('$2y$13$6WwqG/PG8a620UjrISfMLer/ad73D94lPQxITuQH7gJtqR.df5VzW');

$manager->persist($user);

$admin = new User();
$admin->setUsername('adminOlivier');
$admin->setPassword('$2y$13$Ttp1ATP6mDoPE5P/QPYoZOEdDdsiB/hsIvCRuMcdBfR6k0O4LgMwu');
$admin->setRoles(['ROLE_ADMIN']);

$manager->persist($admin);
        $manager->flush();
    }
}
