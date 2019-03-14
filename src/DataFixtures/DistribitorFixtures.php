<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Distributor;

class DistribitorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $distributor1 = new Distributor();
        $distributor1->setName('CNR');
        $distributor1->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor1);
        
        $distributor2 = new Distributor();
        $distributor2->setName('EMI');
        $distributor2->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor2);
        
        $distributor3 = new Distributor();
        $distributor3->setName('PIAS');
        $distributor3->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor3);
        
        $distributor4 = new Distributor();
        $distributor4->setName('Sony');
        $distributor4->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor4);
        
        $distributor5 = new Distributor();
        $distributor5->setName('Universal');
        $distributor5->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor5);
        
        $distributor6 = new Distributor();
        $distributor6->setName('V2');
        $distributor6->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor6);
        
        $distributor7 = new Distributor();
        $distributor7->setName('Virgin');
        $distributor7->setStatus(Distributor::STATUS_INACTIVE);
        $manager->persist($distributor7);
        
        $distributor8 = new Distributor();
        $distributor8->setName('Warner');
        $distributor8->setStatus(Distributor::STATUS_ACTIVE);
        $manager->persist($distributor8);
        
        $distributor9 = new Distributor();
        $distributor9->setName('Play It Again Sam');
        $distributor9->setStatus(Distributor::STATUS_DELETED);
        $manager->persist($distributor9);

        $manager->flush();
    }
}
