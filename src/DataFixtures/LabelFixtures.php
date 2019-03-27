<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Label;

class LabelFixtures extends Fixture
{
    public const LABEL_1 = 'label1';
    public const LABEL_2 = 'label2';
    public const LABEL_3 = 'label3';
    public const LABEL_4 = 'label4';
    public const LABEL_5 = 'label5';
    public const LABEL_6 = 'label6';
    public const LABEL_7 = 'label7';
    public const LABEL_8 = 'label8';
    public const LABEL_9 = 'label9';
    public const LABEL_10 = 'label10';
    public const LABEL_11 = 'label11';
    public const LABEL_12 = 'label12';
    public const LABEL_13 = 'label13';
    public const LABEL_14 = 'label14';
    public const LABEL_15 = 'label15';
    public const LABEL_16 = 'label16';
    public const LABEL_17 = 'label17';
    public const LABEL_18 = 'label18';
    public const LABEL_19 = 'label19';
    public const LABEL_20 = 'label20';
    
    /**
     * Generate test data for the labels
     * 
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $label1 = new Label();
        $label1->setName('4AD');
        $label1->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label1);
        
        $label2 = new Label();
        $label2->setName('Bella Union');
        $label2->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label2);
        
        $label3 = new Label();
        $label3->setName('Blue Note');
        $label3->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label3);
        
        $label4 = new Label();
        $label4->setName('Columbia');
        $label4->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label4);
        
        $label5 = new Label();
        $label5->setName('Epic');
        $label5->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label5);
        
        $label6 = new Label();
        $label6->setName('Geffen');
        $label6->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label6);
        
        $label7 = new Label();
        $label7->setName('Hut');
        $label7->setStatus(Label::STATUS_INACTIVE);
        $manager->persist($label7);
        
        $label8 = new Label();
        $label8->setName('Interscope');
        $label8->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label8);
        
        $label9 = new Label();
        $label9->setName('Matador');
        $label9->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label9);
        
        $label10 = new Label();
        $label10->setName('Parlophone');
        $label10->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label10);
        
        $label11 = new Label();
        $label11->setName('PIAS');
        $label11->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label11);
        
        $label12 = new Label();
        $label12->setName('Polydor');
        $label12->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label12);
        
        $label13 = new Label();
        $label13->setName('Roadrunner');
        $label13->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label13);
        
        $label14 = new Label();
        $label14->setName('Universal');
        $label14->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label14);
        
        $label15 = new Label();
        $label15->setName('V2');
        $label15->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label15);
        
        $label16 = new Label();
        $label16->setName('Vertigo');
        $label16->setStatus(Label::STATUS_INACTIVE);
        $manager->persist($label16);
        
        $label17 = new Label();
        $label17->setName('Warner Bros.');
        $label17->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label17);
        
        $label18 = new Label();
        $label18->setName('Wichita');
        $label18->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label18);

        $label19 = new Label();
        $label19->setName('XL');
        $label19->setStatus(Label::STATUS_ACTIVE);
        $manager->persist($label19);
        
        $label20 = new Label();
        $label20->setName('Play It Again Sam');
        $label20->setStatus(Label::STATUS_DELETED);
        $manager->persist($label20);
        
        $manager->flush();
        
        $this->addReference(self::LABEL_1, $label1);
        $this->addReference(self::LABEL_2, $label2);
        $this->addReference(self::LABEL_3, $label3);
        $this->addReference(self::LABEL_4, $label4);
        $this->addReference(self::LABEL_5, $label5);
        $this->addReference(self::LABEL_6, $label6);
        $this->addReference(self::LABEL_7, $label7);
        $this->addReference(self::LABEL_8, $label8);
        $this->addReference(self::LABEL_9, $label9);
        $this->addReference(self::LABEL_10, $label10);
        $this->addReference(self::LABEL_11, $label11);
        $this->addReference(self::LABEL_12, $label12);
        $this->addReference(self::LABEL_13, $label13);
        $this->addReference(self::LABEL_14, $label14);
        $this->addReference(self::LABEL_15, $label15);
        $this->addReference(self::LABEL_16, $label16);
        $this->addReference(self::LABEL_17, $label17);
        $this->addReference(self::LABEL_18, $label18);
        $this->addReference(self::LABEL_19, $label19);
        $this->addReference(self::LABEL_20, $label20);
    }
}
