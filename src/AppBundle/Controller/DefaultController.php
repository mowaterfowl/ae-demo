<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use AppBundle\RockPaperScissorsLizardSpock;
	use AppBundle\Entity\Fight;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;


	class DefaultController extends Controller
	{
		/**
		 * @Route("/", name="homepage")
		 */
		public function indexAction(Request $request)
		{



			// build our form, we want single click interaction thus submit buttons will be easier
			$form = $this->createFormBuilder()
				->add('rock', SubmitType::class, array('label' => 'Rock'))
				->add('paper', SubmitType::class, array('label' => 'Paper'))
				->add('scissors', SubmitType::class, array('label' => 'Scissors'))
				->add('lizard', SubmitType::class, array('label' => 'Lizard'))
				->add('spock', SubmitType::class, array('label' => 'Spock'))
				->getForm();


			$form->handleRequest($request);  // assign the request information to the form object
			if ($form->isSubmitted()) {

				$rpsls = new RockPaperScissorsLizardSpock(); // The object for controlling our game's functions
				$weaponOptions = array("scissors","paper","rock", "lizard", "spock");


				foreach ($weaponOptions as $weapon){
					// find out what weapon the player chose
					// NOTE: PHPStorm tells us the isClicked() method is undefined.  It lies.
					if($form->get($weapon)->isClicked()){
						$playerWeapon = $weapon;
					}

				}

				$fightResults = $rpsls->fight($playerWeapon); // who is the strongest?

				// update the database with the results
				$fight = new Fight();
				$fight->setAIWeapon($fightResults['AiWeapon']);
				$fight->setPlayerWeapon($fightResults['PlayerWeapon']);
				$fight->setWinner($fightResults['Winner']);
				$em = $this->getDoctrine()->getManager();
				$em->persist($fight);
				$em->flush();



				// output the results back to the page
				return $this->render('default/index.html.twig', [
					'base_dir'     => realpath($this->getParameter('kernel.root_dir') . '/..'),
					'winner'       => $fightResults['Winner'],
					'aiWeapon'     => $fightResults['AiWeapon'],
					'playerWeapon' => $fightResults['PlayerWeapon'],
					'ourForm'      => $form->createView()
				]);

			} else {

				// the page view if the form wasn't submitted (first view)
				return $this->render('default/index.html.twig', [
					'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
					'ourForm'  => $form->createView()]);
			}
		}

	}
