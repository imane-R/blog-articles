<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitre("Article $i ");
            $article->setContenu('lorem ipsum dolor sit amet, consectet adip e parturient montes rec  otherwise  unknown');
            $article->setDateDeCreation(new DateTime("now"));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
