<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Album;

use DateTime;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Generate test data for the albums
     * 
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $album1 = new Album();
        $album1->setMultipleArtists(false);
        $album1->setArtist($this->getReference(ArtistFixtures::ARTIST_19));
        $album1->setTitle('The Bends');
        $album1->setLabel($this->getReference(LabelFixtures::LABEL_10));
        $album1->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_2));
        $album1->setReleaseYear(1995);
        $date1 = new DateTime('1995/03/13');
        $album1->setReleaseDate($date1);
        $album1->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album1);
        
        $album2 = new Album();
        $album2->setMultipleArtists(false);
        $album2->setArtist($this->getReference(ArtistFixtures::ARTIST_1));
        $album2->setTitle('Admiral Freebee');
        $album2->setLabel($this->getReference(LabelFixtures::LABEL_12));
        $album2->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_5));
        $album2->setReleaseYear(2003);
        $date2 = new DateTime('2003/02/07');
        $album2->setReleaseDate($date2);
        $album2->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album2);

        $album3 = new Album();
        $album3->setMultipleArtists(false);
        $album3->setArtist($this->getReference(ArtistFixtures::ARTIST_4));
        $album3->setTitle('Gang Of Losers');
        $album3->setLabel($this->getReference(LabelFixtures::LABEL_2));
        $album3->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album3->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album3);
        
        $album4 = new Album();
        $album4->setMultipleArtists(true);
        $album4->setTitle('De Afrekening 17');
        $album4->setLabel($this->getReference(LabelFixtures::LABEL_14));
        $album4->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_5));
        $album4->setReleaseYear(1999);
        $album4->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album4);

        $album5 = new Album();
        $album5->setMultipleArtists(false);
        $album5->setArtist($this->getReference(ArtistFixtures::ARTIST_30));
        $album5->setTitle('Yes, Virginia');
        $album5->setLabel($this->getReference(LabelFixtures::LABEL_13));
        $album5->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_1));
        $album5->setReleaseYear(2006);
        $date5 = new DateTime('2006/04/20');
        $album5->setReleaseDate($date5);
        $album5->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album5);
        
        $album6 = new Album();
        $album6->setMultipleArtists(false);
        $album6->setArtist($this->getReference(ArtistFixtures::ARTIST_15));
        $album6->setTitle('Nevermind');
        $album6->setLabel($this->getReference(LabelFixtures::LABEL_6));
        $album6->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_5));
        $album6->setReleaseYear(1991);
        $date6 = new DateTime('1991/9/24');
        $album6->setReleaseDate($date6);
        $album6->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album6);

        $album7 = new Album();
        $album7->setMultipleArtists(false);
        $album7->setArtist($this->getReference(ArtistFixtures::ARTIST_17));
        $album7->setTitle('Ten');
        $album7->setLabel($this->getReference(LabelFixtures::LABEL_5));
        $album7->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_4));
        $album7->setReleaseYear(1991);
        $date7 = new DateTime('1991/08/27');
        $album7->setReleaseDate($date7);
        $album7->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album7);
        
        $album8 = new Album();
        $album8->setMultipleArtists(false);
        $album8->setArtist($this->getReference(ArtistFixtures::ARTIST_20));
        $album8->setTitle('Ágætis Byrjun');
        $album8->setLabel($this->getReference(LabelFixtures::LABEL_11));
        $album8->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_3));
        $album8->setReleaseYear(2000);
        $date8 = new DateTime('2000/09/04');
        $album8->setReleaseDate($date8);
        $album8->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album8);

        $album9 = new Album();
        $album9->setMultipleArtists(false);
        $album9->setArtist($this->getReference(ArtistFixtures::ARTIST_31));
        $album9->setTitle('Mellon Collie & The Infinite Sadness');
        $album9->setLabel($this->getReference(LabelFixtures::LABEL_7));
        $album9->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_7));
        $album9->setReleaseYear(1995);
        $date9 = new DateTime('1995/10/24');
        $album9->setReleaseDate($date9);
        $album9->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album9);      
        
        $album10 = new Album();
        $album10->setMultipleArtists(false);
        $album10->setArtist($this->getReference(ArtistFixtures::ARTIST_14));
        $album10->setTitle('Metallica');
        $album10->setAlternativeTitle('The Black Album');
        $album10->setLabel($this->getReference(LabelFixtures::LABEL_16));
        $album10->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_5));
        $album10->setReleaseYear(1991);
        $date10 = new DateTime('1991/08/03');
        $album10->setReleaseDate($date10);
        $album10->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album10);
        
        $album11 = new Album();
        $album11->setMultipleArtists(true);
        $album11->setArtist($this->getReference(ArtistFixtures::ARTIST_28));
        $album11->setTitle('Blue Note Caliente!');
        $album11->setLabel($this->getReference(LabelFixtures::LABEL_3));
        $album11->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_2));
        $album11->setReleaseYear(2004);
        $album11->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album11);
        
        $album12 = new Album();
        $album12->setMultipleArtists(true);
        $album12->setTitle('Duyster.');
        $album12->setLabel($this->getReference(LabelFixtures::LABEL_10));
        $album12->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_3));
        $album12->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album12);
        
        $album13 = new Album();
        $album13->setMultipleArtists(false);
        $album13->setArtist($this->getReference(ArtistFixtures::ARTIST_2));
        $album13->setTitle('The Flying Club Cub');
        $album13->setLabel($this->getReference(LabelFixtures::LABEL_1));
        $album13->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album13->setReleaseYear(2007);
        $date13 = new DateTime('2007/10/05');
        $album13->setReleaseDate($date13);
        $album13->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album13);
        
        $album14 = new Album();
        $album14->setMultipleArtists(false);
        $album14->setArtist($this->getReference(ArtistFixtures::ARTIST_3));
        $album14->setTitle('Clap Your Hands Say Yeah');
        $album14->setLabel($this->getReference(LabelFixtures::LABEL_18));
        $album14->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album14->setReleaseYear(2006);
        $date14 = new DateTime('2006/01/20');
        $album14->setReleaseDate($date14);
        $album14->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album14);
        
        $album15 = new Album();
        $album15->setMultipleArtists(false);
        $album15->setArtist($this->getReference(ArtistFixtures::ARTIST_3));
        $album15->setTitle('Hysterical');
        $album15->setLabel($this->getReference(LabelFixtures::LABEL_18));
        $album15->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album15->setReleaseYear(2011);
        $date15 = new DateTime('2011/09/09');
        $album15->setReleaseDate($date15);
        $album15->setStatus(Album::STATUS_INACTIVE);
        $manager->persist($album15);
        
        $album16 = new Album();
        $album16->setMultipleArtists(false);
        $album16->setArtist($this->getReference(ArtistFixtures::ARTIST_3));
        $album16->setTitle('Some Loud Thunder');
        $album16->setLabel($this->getReference(LabelFixtures::LABEL_15));
        $album16->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album16->setReleaseYear(2007);
        $date16 = new DateTime('2007/01/26');
        $album16->setReleaseDate($date16);
        $album16->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album16);
        
        $album17 = new Album();
        $album17->setMultipleArtists(false);
        $album17->setArtist($this->getReference(ArtistFixtures::ARTIST_19));
        $album17->setTitle('Kid A');
        $album17->setLabel($this->getReference(LabelFixtures::LABEL_10));
        $album17->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_2));
        $album17->setReleaseYear(2000);
        $date17 = new DateTime('2000/09/29');
        $album17->setReleaseDate($date17);
        $album17->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album17);
        
        $album18 = new Album();
        $album18->setMultipleArtists(false);
        $album18->setArtist($this->getReference(ArtistFixtures::ARTIST_19));
        $album18->setTitle('OK Computer');
        $album18->setLabel($this->getReference(LabelFixtures::LABEL_10));
        $album18->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_8));
        $album18->setReleaseYear(1997);
        $date18 = new DateTime('1997/06/16');
        $album18->setReleaseDate($date18);
        $album18->setStatus(Album::STATUS_ACTIVE);
        $manager->persist($album18);
        
        $album19 = new Album();
        $album19->setMultipleArtists(false);
        $album19->setArtist($this->getReference(ArtistFixtures::ARTIST_19));
        $album19->setTitle('In Rainbows');
        $album19->setLabel($this->getReference(LabelFixtures::LABEL_19));
        $album19->setDistributor($this->getReference(DistribitorFixtures::DISTRIBUTOR_6));
        $album19->setReleaseYear(2007);
        $date19 = new DateTime('2007/12/28');
        $album19->setReleaseDate($date19);
        $album19->setStatus(Album::STATUS_INACTIVE);
        $manager->persist($album19);

        $manager->flush();
    }
    
    /**
     * Set the necessary dependencies
     * 
     * @return type
     */
    public function getDependencies()
    {
        return [
            ArtistFixtures::class,
            LabelFixtures::class,
            DistribitorFixtures::class
        ];
    }
}
