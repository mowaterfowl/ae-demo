<?php
	/**
	 * Created by PhpStorm.
	 * User: Chris
	 * Date: 3/4/2016
	 * Time: 4:43 AM
	 */

	namespace AppBundle;


	class RockPaperScissorsLizardSpock
	{


	public function fight($playerWeapon = "lizard"){

		/*
		no need to reinvent the wheel, but let's give credit where credit is
		due.  For reference by future developers...

		*** based on https://rosettacode.org/wiki/Rock-paper-scissors#C.23 ***
		*/

		// our assortment of weapons.  IMPORTANT! The order they're assigned in the index
		// directly affects the way the winner is determined.

		$arrayWeapons = array("scissors","paper","rock", "lizard", "spock");

		$aiWeapon = $arrayWeapons[random_int(0,4)];
		$iWeaponIndex = array_search($playerWeapon, $arrayWeapons);

		if($playerWeapon === $aiWeapon){

			$ReturnArray = array(
				'Winner' => 'DRAW',
				'PlayerWeapon' => $playerWeapon,
				'AiWeapon' => $aiWeapon
			);
			return $ReturnArray;

		} else {

			// THERE CAN BE ONLY ONE!

			/*
			if the player's weapon is odd, and the last one in the set (spock),
			then the first item loses to it (but we don't stop there)
			*/

			if($iWeaponIndex % 2 != 0 && $iWeaponIndex == (count($arrayWeapons)-1)){
				$losingWeapons[0] = $arrayWeapons[$iWeaponIndex];
			}

			/*
			if the index is even, then all even indicies less than it and
			all odd indices greater lose to the player's weapon
			*/
			for($i = $iWeaponIndex - 2; $i >=0; $i -= 2){
				$losingWeapons[] = $arrayWeapons[$i];
			}

			for($i = $iWeaponIndex + 1; $i < count($arrayWeapons); $i += 2){
				$losingWeapons[] = $arrayWeapons[$i];
			}

			// search the losingWeapons array for the ai's weapon
			$Winner = (in_array($aiWeapon,$losingWeapons) ? 'PLAYER' : 'AI OPPONENT');
			$ReturnArray = array(
				'Winner' => $Winner,
				'PlayerWeapon' => $playerWeapon,
				'AiWeapon' => $aiWeapon
			);

			return $ReturnArray;

		}

	}

	}