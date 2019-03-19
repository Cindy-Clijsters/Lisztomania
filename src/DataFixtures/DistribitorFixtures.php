<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Distributor;

class DistribitorFixtures extends Fixture
{
    public const DISTRIBUTOR_1 = 'distributor1';
    public const DISTRIBUTOR_2 = 'distributor2';
    public const DISTRIBUTOR_3 = 'distributor3';
    public const DISTRIBUTOR_4 = 'distributor4';
    public const DISTRIBUTOR_5 = 'distributor5';
    public const DISTRIBUTOR_6 = 'distributor6';
    public const DISTRIBUTOR_7 = 'distributor7';
    public const DISTRIBUTOR_8 = 'distributor8';
    public const DISTRIBUTOR_9 = 'distributor9';
    
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
        
        $this->addReference(self::DISTRIBUTOR_1, $distributor1);
        $this->addReference(self::DISTRIBUTOR_2, $distributor2);
        $this->addReference(self::DISTRIBUTOR_3, $distributor3);
        $this->addReference(self::DISTRIBUTOR_4, $distributor4);
        $this->addReference(self::DISTRIBUTOR_5, $distributor5);
        $this->addReference(self::DISTRIBUTOR_6, $distributor6);
        $this->addReference(self::DISTRIBUTOR_7, $distributor7);
        $this->addReference(self::DISTRIBUTOR_8, $distributor8);
        $this->addReference(self::DISTRIBUTOR_9, $distributor9);
    }
}
