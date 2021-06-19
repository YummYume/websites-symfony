<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Website;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $saintVincent = new Client();
        $saintVincent->setCompanyName("Lycée Saint Vincent");
        $saintVincent->setContactName("Idasiak");
        $saintVincent->setContactEmail("stvincent@gmail.com");
        $saintVincent->setContactPhone("0606060606");
        $saintVincent->setDate(new DateTime("NOW"));
        $manager->persist($saintVincent);

        $doABarrelRoll = new Client();
        $doABarrelRoll->setCompanyName("Star Fox 64");
        $doABarrelRoll->setContactName("Peppy Hare");
        $doABarrelRoll->setContactPhone("+33706060606");
        $doABarrelRoll->setDate(new DateTime("NOW"));
        $manager->persist($doABarrelRoll);

        $ec2e = new Client();
        $ec2e->setCompanyName("EC2E");
        $ec2e->setContactName("Léo");
        $ec2e->setContactEmail("leo@gmail.com");
        $ec2e->setDate(new DateTime("NOW"));
        $manager->persist($ec2e);

        $mentalworks = new Client();
        $mentalworks->setCompanyName("MentalWorks");
        $mentalworks->setContactName("Jeff");
        $mentalworks->setContactEmail("jeff@gmail.com");
        $mentalworks->setDate(new DateTime("NOW"));
        $manager->persist($mentalworks);

        $saintVincentWebsite = new Website();
        $saintVincentWebsite->setName("Saint Vincent");
        $saintVincentWebsite->setLink("https://www.lycee-stvincent.fr/");
        $saintVincentWebsite->setClient($saintVincent);
        $saintVincentWebsite->setPHP("7.2");
        $saintVincentWebsite->setDate(new DateTime("NOW"));
        $manager->persist($saintVincentWebsite);

        $doABarrelRollWebsite = new Website();
        $doABarrelRollWebsite->setName("Do A Barrel Roll");
        $doABarrelRollWebsite->setLink("https://www.google.fr/search?q=do+a+barrel+roll");
        $doABarrelRollWebsite->setClient($doABarrelRoll);
        $doABarrelRollWebsite->setDate(new DateTime("NOW"));
        $manager->persist($doABarrelRollWebsite);

        $ec2eWebsite = new Website();
        $ec2eWebsite->setName("EC2E");
        $ec2eWebsite->setLink("http://www.ec2e.com/fr/");
        $ec2eWebsite->setClient($ec2e);
        $ec2eWebsite->setPHP("7.0");
        $ec2eWebsite->setDate(new DateTime("NOW"));
        $manager->persist($ec2eWebsite);

        $mentalworksWebsite = new Website();
        $mentalworksWebsite->setName("MentalWorks");
        $mentalworksWebsite->setLink("https://www.mentalworks.fr/");
        $mentalworksWebsite->setClient($mentalworks);
        $mentalworksWebsite->setPHP("7.4");
        $mentalworksWebsite->setDate(new DateTime("NOW"));
        $manager->persist($mentalworksWebsite);

        $manager->flush();
    }
}
