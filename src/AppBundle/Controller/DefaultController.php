<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\RockPaperScissorsLizardSpock;
use AppBundle\Form\FormRPSLS;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $rpsls = new RockPaperScissorsLizardSpock(); // The object for controlling our game's functions
		$fight = $rpsls->fight("rock");
        //$formRPSLS = new FormRPSLS();

		//$form = $this->createForm(new FormRPSLS(),$rpsls);


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'winner' => $fight['Winner'],
			'aiWeapon' => $fight['AiWeapon'],
			'playerWeapon' => $fight['PlayerWeapon']
        ]);
    }
}
