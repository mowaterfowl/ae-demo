<?php
	/**
	 * Created by PhpStorm.
	 * User: Chris
	 * Date: 3/4/2016
	 * Time: 4:43 AM
	 */

	namespace AppBundle;

	use Doctrine\ORM\EntityManager;

	class RockPaperScissorsLizardSpock
	{

		private $entityManager;


		public function __construct(EntityManager $entityManager)
		{
			$this->entityManager = $entityManager;
		}

		public function getPlayerStats()
		{

			// get the player's stats on weapon choice from the database

			$conn           = $this->entityManager->getConnection();
			$sqlPlayerStats = $conn->prepare("SELECT COUNT(PlayerWeapon) as TimesSelected, PlayerWeapon as Weapon
											  FROM fights
											  GROUP BY PlayerWeapon");
			$sqlPlayerStats->execute();
			$playerResults = $sqlPlayerStats->fetchAll();

			if ($playerResults) {
				// flatten the results
				foreach ($playerResults as $row) {
					$playerStats[$row['Weapon']] = $row['TimesSelected'];
				}

				if ($playerStats) {
					return $playerStats;
				}
			}
		}

		public function getAiStats()
		{

			// get the ai's stats on weapon choice from the database

			$conn       = $this->entityManager->getConnection();
			$sqlAiStats = $conn->prepare("SELECT COUNT(AiWeapon) as TimesSelected, AiWeapon as Weapon
										  FROM fights
										  GROUP BY AiWeapon");
			$sqlAiStats->execute();
			$aiResults = $sqlAiStats->fetchAll();

			if ($aiResults) {
				// flatten the results
				foreach ($aiResults as $row) {
					$aiStats[$row['Weapon']] = $row['TimesSelected'];
				}

				if ($aiStats) {
					return $aiStats;
				}
			}

		}

		public function getWinLossStats()
		{

			// get the win count for each of the players

			$conn       = $this->entityManager->getConnection();
			$sqlWLStats = $conn->prepare("SELECT Winner, COUNT(FightID) AS TotalGames
										  FROM Fights
										  GROUP BY Winner");
			$sqlWLStats->execute();
			$wlResults = $sqlWLStats->fetchAll();

			if ($wlResults) {

				// flatten the results
				foreach ($wlResults as $row) {
					$wlStats[$row['Winner']] = $row['TotalGames'];
				}

				if ($wlStats) {
					return $wlStats;
				}
			}
		}

		public function fight($playerWeapon = "rock")
		{

			/*
			no need to reinvent the wheel, but let's give credit where credit is
			due.  For reference by future developers...

			*** based on https://rosettacode.org/wiki/Rock-paper-scissors#C.23 ***
			*/

			// our assortment of weapons.  IMPORTANT! The order they're assigned in the index
			// directly affects the way the winner is determined.

			$arrayWeapons = array("scissors", "paper", "rock", "lizard", "spock");

			$aiWeapon     = $arrayWeapons[random_int(0, 4)];
			$iWeaponIndex = array_search($playerWeapon, $arrayWeapons);

			if ($playerWeapon === $aiWeapon) {

				$ReturnArray = array(
					'Winner'       => 'DRAW',
					'PlayerWeapon' => $playerWeapon,
					'AiWeapon'     => $aiWeapon
				);
				return $ReturnArray;

			} else {

				// THERE CAN BE ONLY ONE!

				/*
				if the player's weapon is odd, and the last one in the set (spock),
				then the first item loses to it (but we don't stop there)
				*/

				if ($iWeaponIndex % 2 != 0 && $iWeaponIndex == (count($arrayWeapons) - 1)) {
					$losingWeapons[0] = $arrayWeapons[$iWeaponIndex];
				}

				/*
				if the index is even, then all even indicies less than it and
				all odd indices greater lose to the player's weapon
				*/
				for ($i = $iWeaponIndex - 2; $i >= 0; $i -= 2) {
					$losingWeapons[] = $arrayWeapons[$i];
				}

				for ($i = $iWeaponIndex + 1; $i < count($arrayWeapons); $i += 2) {
					$losingWeapons[] = $arrayWeapons[$i];
				}

				// search the losingWeapons array for the ai's weapon
				$Winner      = (in_array($aiWeapon, $losingWeapons) ? 'PLAYER' : 'AI');
				$ReturnArray = array(
					'Winner'       => $Winner,
					'PlayerWeapon' => $playerWeapon,
					'AiWeapon'     => $aiWeapon
				);


				return $ReturnArray;

			}

		}

	}