<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test-home', name: 'app_test')]

    public function index(): Response
    {
        $article = [
            'titre' => "Why does the brain need so much power?",
            'dateDeCreation' => "10/01/2023",
            'auteur' => "Imane",
            'contenu' => "The human brain is the most complex organ in the body, and it requires a lot of energy to function properly. The brain uses about 20% of the body's total energy, even though it only makes up about 2% of the body's weight.
            The brain is made up of billions of cells called neurons, which use electricity to communicate with each other. This electrical activity requires a lot of energy. In addition, the brain is constantly working to process information, make decisions, and control the body's movements, which also requires a lot of energy.
            
            The average human brain has the same basic structure as the brains of other mammals, but is larger in relation to body size than any other brain. The human brain is the most energy-hungry organ in the body, using 20 percent of the body’s energy supply. It is also the fattiest organ in the body, containing 60 percent fat.
            
            So why does the brain need so much power? One reason is that the brain is constantly active, even when a person is at rest. The brain is constantly sending and receiving signals, and processing information. This requires a lot of energy.
            
            Another reason the brain needs so much power is that it is constantly growing and changing. The brain is constantly making new connections and strengthening existing ones. This process, called neuroplasticity, requires a lot of energy.
            
            Lastly, the brain needs a lot of power because it is very sensitive to changes in the environment. The brain is constantly making adjustments to keep the body in balance. For example, the brain regulates body temperature, blood pressure, and heart rate. These processes require a lot of energy.
            
            The brain is an amazing organ that requires a lot of energy to function properly. By understanding why the brain needs so much power, we can better appreciate the importance of taking care of our brains."
        ];
        return $this->render('test.html.twig', [
            'article' => $article

        ]); //render permet d'envoyer une page 
    }

    //  var article = tab tout les info d'un article  publication auteur contenu 

}
