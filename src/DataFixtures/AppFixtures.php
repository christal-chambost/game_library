<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder; 

    public function __construct( UserPasswordHasherInterface $encoder)
    {

        $this->encoder = $encoder;

    }
    public function load(ObjectManager $manager): void
    {
        //USER
        $superAdmin = new User();
        $hash = $this->encoder->hashPassword($superAdmin, "password");
        $superAdmin->setUsername("superAdmin");
        $superAdmin->setPassword($hash);
        $superAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($superAdmin);

        $user = new User();
        $hash = $this->encoder->hashPassword($superAdmin, "zozo2804hell");
        $user->setUsername("christal");
        $user->setPassword($hash);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        //CATEGORIES
        $action = new Category();
        $action->setName("action")
            ->setSlug(strtolower($action->getName()))
            ->setColor("#8d3061");
        $manager->persist($action);
        $rpg = new Category();
        $rpg->setName("RPG")
            ->setSlug(strtolower($rpg->getName()))
            ->setColor("#ff3366ff");
        $manager->persist($rpg);
        $strategy = new Category();
        $strategy->setName("strategy")
            ->setSlug(strtolower($strategy->getName()))
            ->setColor("#2ec4b6ff");
        $manager->persist($strategy);
        $aventurecasual = new Category();
        $aventurecasual->setName("aventure et casual")
            ->setSlug(strtolower($aventurecasual->getName()))
            ->setColor("#20a4f3ff");
        $manager->persist($aventurecasual);
        $simulation = new Category();
        $simulation->setName("simulation")
            ->setSlug(strtolower($simulation->getName()))
            ->setColor("#f6f7f8ff");
        $manager->persist($simulation);
        $sportcourse = new Category();
        $sportcourse->setName("sport et course")
            ->setSlug(strtolower($sportcourse->getName()))
            ->setColor("#f5bb00ff");
        $manager->persist($sportcourse);
        $autre = new Category();
        $autre->setName("autre")
            ->setSlug(strtolower($autre->getName()))
            ->setColor("#8ea604ff");
        $manager->persist($autre);

        //GAMES
        $lostark = new Game();
        $lostark->setName("lost ark")
            ->setSlug("lost-ark")
            ->setImage("https://zupimages.net/up/22/10/pat2.jpg")
            ->setDescription("Explorez le vaste monde d'Archésia. Faites votre choix parmi diverses classes avancées pour personnaliser votre style de combat tandis que vous combattez des légions de démons, des boss colossaux et bien plus encore dans votre quête de l'Arche.")
            ->setCategory($rpg);
        $manager->persist($lostark);

        $staxel = new Game();
        $staxel->setName("staxel")
            ->setSlug("staxel")
            ->setImage("https://zupimages.net/up/22/10/n90e.jpg")
            ->setDescription("Faites grandir votre ferme, rencontrez les villageois et rejoignez vos amis en ligne pour construire votre monde.")
            ->setCategory($rpg);
        $manager->persist($staxel);

        $undertale = new Game();
        $undertale->setName("undertale")
            ->setSlug("undertale")
            ->setImage("https://zupimages.net/up/22/10/su0t.jpg")
            ->setDescription("UNDERTALE! The RPG game where you don't have to destroy anyone.")
            ->setCategory($rpg);
        $manager->persist($undertale);

        $amongus = new Game();
        $amongus->setName("among us")
            ->setSlug("among-us")
            ->setImage("https://zupimages.net/up/22/10/jgrs.jpg")
            ->setDescription("Travail d'équipe et trahison sont les maîtres mots dans ce party-game local et en ligne pour 4 à 15 joueurs... dans l'espace !")
            ->setCategory($aventurecasual);
        $manager->persist($amongus);

        $daystodie = new Game();
        $daystodie->setName("7 days to die")
            ->setSlug("7-days-to-die")
            ->setImage("https://zupimages.net/up/22/10/g7wd.jpg")
            ->setDescription("7 Days to Die is an open-world game that is a unique combination of first person shooter, survival horror, tower defense, and role-playing games. Play the definitive zombie survival sandbox RPG that came first. Navezgane awaits!")
            ->setCategory($action);
        $manager->persist($daystodie);

        $manager->flush();
    }
}