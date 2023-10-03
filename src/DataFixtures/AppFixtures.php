<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use App\Entity\Sector;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const CONTRACT_TYPES = ["CDI", "CDD", "Intérim"];

    private const SECTOR = ["RH", "Informatique", "Comptabilité", "Direction"];

    private const NB_EMPLOYEES = 15;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $contractTypes = [];

        foreach (self::CONTRACT_TYPES as $contractTypeName) {
            $contractType = new ContractType;
            $contractType->setName($contractTypeName);
            $manager->persist($contractType);
            $contractTypes[] = $contractType;
        }

        $sectors = [];

        foreach (self::SECTOR as $sectorName) {
            $sector = new Sector;
            $sector->setName($sectorName);
            $manager->persist($sector);
            $sectors[] = $sector;
        }

        for ($i = 0; $i < self::NB_EMPLOYEES; $i++) {
            $regularUser = new User();
            $regularUser
                ->setEmail($faker->email())
                ->setPassword($this->hasher->hashPassword($regularUser, 'test'))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setFacePicture($faker->imageUrl())
                ->setRoles(['ROLE_USER'])
                ->setRealiseDate($faker->dateTimeBetween('now', '+2 years'))
                ->setContractType($faker->randomElement($contractTypes))
                ->setSector($faker->randomElement($sectors));

            $manager->persist($regularUser);
        }

        $adminUser = new User();
        $adminUser
            ->setEmail('rh@hb.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($adminUser, 'azerty123'))
            ->setFirstname('Marie')
            ->setLastname('Curie')
            ->setFacePicture('https://via.placeholder.com/640x480.png/00ee33?text=rerum');

        $manager->persist($adminUser);


        $manager->flush();
    }
}
