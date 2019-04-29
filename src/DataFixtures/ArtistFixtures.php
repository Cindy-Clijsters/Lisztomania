<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public const ARTIST_1  = 'artist1';
    public const ARTIST_2  = 'artist2';
    public const ARTIST_3  = 'artist3';
    public const ARTIST_4  = 'artist4';
    public const ARTIST_5  = 'artist5';
    public const ARTIST_6  = 'artist6';
    public const ARTIST_7  = 'artist7';
    public const ARTIST_8  = 'artist8';
    public const ARTIST_9  = 'artist9';
    public const ARTIST_10 = 'artist10';
    public const ARTIST_11 = 'artist11';
    public const ARTIST_12 = 'artist12';
    public const ARTIST_13 = 'artist13';
    public const ARTIST_14 = 'artist14';
    public const ARTIST_15 = 'artist15';
    public const ARTIST_16 = 'artist16';
    public const ARTIST_17 = 'artist17';
    public const ARTIST_18 = 'artist18';
    public const ARTIST_19 = 'artist19';
    public const ARTIST_20 = 'artist20';
    public const ARTIST_21 = 'artist21';
    public const ARTIST_22 = 'artist22';
    public const ARTIST_23 = 'artist23';
    public const ARTIST_24 = 'artist24';
    public const ARTIST_25 = 'artist25';
    public const ARTIST_26 = 'artist26';
    public const ARTIST_27 = 'artist27';
    public const ARTIST_28 = 'artist28';
    public const ARTIST_29 = 'artist29';
    public const ARTIST_30 = 'artist30';
    public const ARTIST_31 = 'artist31';
    
    /**
     * Generate test data for the artists
     * 
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $artist1 = new Artist();
        $artist1->setName('Admiral Freebee');
        $artist1->setSortName('Admiral Freebee');
        $artist1->setCountry('BE');
        $artist1->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist1);
        
        $artist2 = new Artist();
        $artist2->setName('Beirut');
        $artist2->setSortName('Beirut');
        $artist2->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist2);
        
        $artist3 = new Artist();
        $artist3->setName('Clap Your Hands Say Yeah');
        $artist3->setSortName('Clap Your Hands Say Yeah');
        $artist3->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist3);
        
        $artist4 = new Artist();
        $artist4->setName('The Dears');
        $artist4->setSortName('Dears (The -)');
        $artist4->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist4);
        
        $artist5 = new Artist();
        $artist5->setName('Eels');
        $artist5->setSortName('Eels');
        $artist5->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist5);
        
        $artist6 = new Artist();
        $artist6->setName('Fever Ray');
        $artist6->setSortName('Fever Ray');
        $artist6->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist6);
        
        $artist7 = new Artist();
        $artist7->setName('Ghinzu');
        $artist7->setSortName('Ghinzu');
        $artist7->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist7);

        $artist8 = new Artist();
        $artist8->setName('Hooverphonic');
        $artist8->setSortName('Hooverphonic');
        $artist8->setCountry('BE');
        $artist8->setStatus(Artist::STATUS_INACTIVE);
        $manager->persist($artist8);

        $artist9 = new Artist();
        $artist9->setName('Isbells');
        $artist9->setSortName('Isbells');
        $artist9->setCountry('BE');
        $artist9->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist9);

        $artist10 = new Artist();
        $artist10->setName('Jeff Buckley');
        $artist10->setSortName('Buckley, Jeff');
        $artist10->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist10);

        $artist11 = new Artist();
        $artist11->setName('The Kills');
        $artist11->setSortName('Kills (The -)');
        $artist11->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist11);

        $artist12 = new Artist();
        $artist12->setName('Linkin Park');
        $artist12->setSortName('Linkin Park');
        $artist12->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist12);

        $artist13 = new Artist();
        $artist13->setName('Mercury Rev');
        $artist13->setSortName('Mercury Rev');
        $artist13->setStatus(Artist::STATUS_INACTIVE);
        $manager->persist($artist13);

        $artist14 = new Artist();
        $artist14->setName('Metallica');
        $artist14->setSortName('Metallica');
        $artist14->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist14);

        $artist15 = new Artist();
        $artist15->setName('Nirvana');
        $artist15->setSortName('Nirvana');
        $artist15->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist15);

        $artist16 = new Artist();
        $artist16->setName('Of Monsters And Men');
        $artist16->setSortName('Of Monsters And Men');
        $artist16->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist16);

        $artist17 = new Artist();
        $artist17->setName('Pearl Jam');
        $artist17->setSortName('Pearl Jam');
        $artist17->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist17);

        $artist18 = new Artist();
        $artist18->setName('Queens Of The Stone Age');
        $artist18->setSortName('Queens Of The Stone Age');
        $artist18->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist18);

        $artist19 = new Artist();
        $artist19->setName('Radiohead');
        $artist19->setSortName('Radiohead');
        $artist19->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist19);

        $artist20 = new Artist();
        $artist20->setName('Sigur Rós');
        $artist20->setSortName('Sigur Rós');
        $artist20->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist20);

        $artist21 = new Artist();
        $artist21->setName('The Tallest Man On Earth');
        $artist21->setSortName('Tallest Man On Earth (The -)');
        $artist21->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist21);
        
        $artist22 = new Artist();
        $artist22->setName('U2');
        $artist22->setSortName('U2');
        $artist22->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist22);

        $artist23 = new Artist();
        $artist23->setName('Vive La Fête');
        $artist23->setSortName('Vive La Fête');
        $artist23->setCountry('BE');
        $artist23->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist23);

        $artist24 = new Artist();
        $artist24->setName('Warpaint');
        $artist24->setSortName('Warpaint');
        $artist24->setStatus(Artist::STATUS_INACTIVE);
        $manager->persist($artist24);

        $artist25 = new Artist();
        $artist25->setName('The XX');
        $artist25->setSortName('XX (The -)');
        $artist25->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist25);

        $artist26 = new Artist();
        $artist26->setName('Yeah Yeah Yeahs');
        $artist26->setSortName('Yeah Yeah Yeahs');
        $artist26->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist26);

        $artist27 = new Artist();
        $artist27->setName('Zornik');
        $artist27->setSortName('Zornik');
        $artist27->setCountry('BE');
        $artist27->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist27);

        $artist28 = new Artist();
        $artist28->setName('Buscemi');
        $artist28->setSortName('Buscemi');
        $artist28->setCountry('BE');
        $artist28->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist28);

        $artist29 = new Artist();
        $artist29->setName('Broken Social Scene');
        $artist29->setSortName('Broken Social Scene');
        $artist29->setStatus(Artist::STATUS_INACTIVE);
        $manager->persist($artist29);

        $artist30 = new Artist();
        $artist30->setName('The Dresden Dolls');
        $artist30->setSortName('Dresden Dolls (The -)');
        $artist30->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist30);  
        
        $artist31 = new Artist();
        $artist31->setName('The Smashing Pumpkins');
        $artist31->setSortName('Smashing Pumpkins (The -)');
        $artist31->setStatus(Artist::STATUS_ACTIVE);
        $manager->persist($artist31); 

        $manager->flush();
        
        $this->addReference(self::ARTIST_1, $artist1);
        $this->addReference(self::ARTIST_2, $artist2);
        $this->addReference(self::ARTIST_3, $artist3);
        $this->addReference(self::ARTIST_4, $artist4);
        $this->addReference(self::ARTIST_5, $artist5);
        $this->addReference(self::ARTIST_6, $artist6);
        $this->addReference(self::ARTIST_7, $artist7);
        $this->addReference(self::ARTIST_8, $artist8);
        $this->addReference(self::ARTIST_9, $artist9);
        $this->addReference(self::ARTIST_10, $artist10);
        $this->addReference(self::ARTIST_11, $artist11);
        $this->addReference(self::ARTIST_12, $artist12);
        $this->addReference(self::ARTIST_13, $artist13);
        $this->addReference(self::ARTIST_14, $artist14);
        $this->addReference(self::ARTIST_15, $artist15);
        $this->addReference(self::ARTIST_16, $artist16);
        $this->addReference(self::ARTIST_17, $artist17);
        $this->addReference(self::ARTIST_18, $artist18);
        $this->addReference(self::ARTIST_19, $artist19);
        $this->addReference(self::ARTIST_20, $artist20);
        $this->addReference(self::ARTIST_21, $artist21);
        $this->addReference(self::ARTIST_22, $artist22);
        $this->addReference(self::ARTIST_23, $artist23);
        $this->addReference(self::ARTIST_24, $artist24);
        $this->addReference(self::ARTIST_25, $artist25);
        $this->addReference(self::ARTIST_26, $artist26);
        $this->addReference(self::ARTIST_27, $artist27);
        $this->addReference(self::ARTIST_28, $artist28);
        $this->addReference(self::ARTIST_29, $artist29);
        $this->addReference(self::ARTIST_30, $artist30);
        $this->addReference(self::ARTIST_31, $artist31);
    }
}
