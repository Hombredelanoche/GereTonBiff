<?php

namespace App\DataFixtures;

use App\Entity\Revenu;
use App\Entity\Statut;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }


    public function load(ObjectManager $manager): void
    {
        $faker =  Factory::create();
        $startDate = new \DateTime('first day of January 2024');
        $statutTab = ['Salarié', 'Cadre', 'Fonctionnaire', 'Apprenti', 'Contrat de Professionnalisation', 'Freelance', 'Indépendant'];

        for ($i = 0; $i < count($statutTab); $i++) {
            $statut = new Statut();
            $statut->setDenomination($statutTab[$i]);
            $statut->setDescription('Ceci est la description du statut ' . $statutTab[$i]);
            switch ($statut->getDenomination()) {
                case 'Salarié':
                    $statut->setTva(0.23);
                    break;
                case 'Cadre':
                    $statut->setTva(0.24);
                    break;
                case 'Fonctionnaire':
                    $statut->setTva(0.24);
                    break;
                case 'Apprenti':
                    $statut->setTva(0.0);
                    break;
                case 'Contrat de Professionnalisation':
                    $statut->setTva(rand(0.4, 0.8));
                    break;
                case 'Freelance':
                    $statut->setTva(rand(0.30, 0.45));
                    break;
                case 'Indépendant':
                    $statut->setTva(rand(0.12, 0.22));
                    break;
                default:
                    $statut->setTva(0);
            }
            $manager->persist($statut);
            $statuts[] = $statut;
        }
        $manager->flush();

        for ($i = 0; $i < 30; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setGenre($faker->randomElement($array = ['male', 'female']));
            $utilisateur->setNom($faker->firstName());
            $utilisateur->setPrenom($faker->lastName());
            $utilisateur->setEmail($faker->email());
            $utilisateur->setPassword($this->userPasswordHasherInterface->hashPassword($utilisateur, $faker->password));
            $utilisateur->setDateDeNaissance($faker->dateTime);
            $utilisateur->setIsVerified($faker->boolean(50));
            $utilisateur->setStatut($faker->randomElement($statuts));
            $manager->persist($utilisateur);
            $utilisateurs[] = $utilisateur;
        }
        $manager->flush();


        foreach ($utilisateurs as $utilisateur) {
            for ($i = 0; $i < 12; $i++) {
                $revenu = new Revenu();
                $moisDate = (clone $startDate)->modify("+$i m");
                $revenu->setMois((int)$moisDate->format('m'));
                $revenu->setSalaire(rand(1400, 10000));
                $revenu->setPrime(rand(0, 3000));
                $revenu->setRessourceSup(rand(0, 1000000));
                $revenu->setUtilisateur($utilisateur);
                $manager->persist($revenu);
            }
        }
        $manager->flush();
    }
}
