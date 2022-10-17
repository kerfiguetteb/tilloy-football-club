<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Joueur;
use App\Entity\Equipe;
use App\Entity\Game;
use App\Entity\Convocation;
use App\Entity\Entraineur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class TestFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->hasher = $hasher;

    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');

        $this->loadGames($manager);
        $this->loadConvocations($manager);
        $this->loadEquipes($manager);
        $this->loadJoueurs($manager, $faker);
        $this->loadEntraineurs($manager, $faker);
        $this->loadUsers($manager);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function loadEquipes(ObjectManager $manager)
    {
        // on par sur un principe que les equipes joue les meme club mais avec des categories diferrentes
        // chaque groupe doit avoir 30 joueur max

        $clubCount = 12;
        $groupeCount = 3;
        $categorieCount = 7;

        
        $clubs=['TILLOY FC','ACHICOURT SCF','ARRAS OF', 'ST LAURENT FEUCHY ES', 'PAS US', 'ST POL US', 
        'HABARCQ CS','ARTESIEN SC', 'BEAUMETZ SUD ARTOIS', 'MONCHY Bs. US', 'CROISILLES US', 'RIVIERE US'];

        $categories =["U8-U9","U10-U11","U12-U13","U14-U15","U16-U17","Senior","Veteran"];

        $groupes = ['A','B','C'];

        foreach ($clubs as $club) {
            foreach ($categories as $categorie) {
                foreach ($groupes as $groupe) {
                    $equipe = new Equipe();
                    $equipe->setNom($club);
                    $equipe->setCategorie($categorie);
                    $equipe->setGroupe($groupe);
                    $manager->persist($equipe);
                }
            }
        }
        $manager->flush();

    }


    public function loadJoueurs(ObjectManager $manager, FakerGenerator $faker): void
    {

        $repository = $this->doctrine->getRepository(Equipe::class);
        $equipes = $repository->findAll();


        foreach ($equipes as $equipe) {
            for ($i = 0; $i < 30; $i++) {
                $joueur = new Joueur();
                $joueur -> setNom($faker->firstName());
                $joueur -> setPrenom($faker->lastName());
                if ($equipe->getCategorie()== "U8-U9") {
                    $joueur -> setAge(rand(8,9));
                }elseif ($equipe->getCategorie()== "U10-U11") {
                    $joueur -> setAge(rand(10,11));
                }elseif ($equipe->getCategorie()== "U12-U13") {
                    $joueur -> setAge(rand(12,13));
                }elseif ($equipe->getCategorie()== "U14-U15") {
                    $joueur -> setAge(rand(14,15));
                }elseif ($equipe->getCategorie()== "U16-U17") {
                    $joueur -> setAge(rand(16,17));
                }elseif ($equipe->getCategorie()== "Senior") {
                    $joueur -> setAge(rand(18,36));
                }elseif ($equipe->getCategorie()== "Veteran") {
                    $joueur -> setAge(rand(37,55));
                }
                $joueur -> setEquipe($equipe);
                $manager->persist($joueur);
            }
        }

        $manager->flush();


    }
    public function loadEntraineurs(ObjectManager $manager, FakerGenerator $faker)
    {
        $repository = $this->doctrine->getRepository(Equipe::class);
        $equipes = $repository->findAll();

        foreach ($equipes as $equipe) {
            $entraineur = new Entraineur();
            $entraineur->setNom($faker->firstName());
            $entraineur->setPrenom($faker->lastName());
            $entraineur->setAge(rand(18,65));
            $entraineur->setEquipe($equipe); 
            $manager->persist($entraineur);
        }
        $manager->flush();
    }

    public function loadGames(ObjectManager $manager): void
    {
        $game = new Game();
        $game -> setNom('TFC vs OAF');
        $manager->persist($game);
        $manager->flush();

    }

    public function loadConvocations(ObjectManager $manager): void
    {
        $repository = $this->doctrine->getRepository(Joueur::class);
        $joueurs = $repository->findAll();
        
        $repository = $this->doctrine->getRepository(Game::class);
        $games = $repository->find(1);


        foreach($joueurs as $joueur)
        {
            $randBool = (bool) mt_rand(0,1);
            $convocation = new Convocation();
            $convocation->setGame($games);
            $convocation->setJoueur($joueur);
            $convocation->setDisponibiliter($randBool);
            $manager->persist($convocation);
        }

        $manager->flush();

    }

    public function loadUsers(ObjectManager $manager): void
    {

        $equipeName = 'TILLOY FC';
        $categorieName = 'Senior';
        $groupeName = 'A';
        $repository = $this->doctrine->getRepository(Equipe::class);
        $tfcSeniorA = $repository->findByNomGroupeCategorie($equipeName,$categorieName,$groupeName);
        $tfcSeniorAId= $tfcSeniorA[0]->getId();
        $repository = $this->doctrine->getRepository(Entraineur::class);
        $entraineur = $repository->findByEquipe($tfcSeniorAId);

        $user = new User;
        $user->setEmail('entraineur@example.com');
        $user->setRoles(['ROLE_ENTRAINEUR']);
        $password = $this->hasher->hashPassword($user, '123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        $entraineur[0]->setUser($user);

        $manager->persist($entraineur[0]);
        $manager->flush();

    }

}
