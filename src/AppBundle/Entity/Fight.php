<?php
	/**
	 * Created by PhpStorm.
	 * User: Chris
	 * Date: 3/4/2016
	 * Time: 12:18 PM
	 */

	namespace AppBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;


	/**
	 * @ORM\Entity(repositoryClass="FightRepository")
	 * @ORM\Table(name="fights")
	 */
	class Fight
	{

		/**
		 * @ORM\Id()
		 * @ORM\GeneratedValue(strategy="AUTO")
		 * @ORM\Column(type="integer")
		 */
		private $FightID;

		/**
		 * @ORM\Column(type="string", name="PlayerWeapon")
		 */
		// in the annotation above, i was forced to specify the column name because
		// doctrine was using system tables to find the column names to match
		// for some unknown reason, it was matching the wrong field (that no longer existed)
		private $PlayerWeapon;

		/**
		 * @ORM\Column(type="string")
		 */
		private $AIWeapon;

		/**
		 * @ORM\Column(type="string")
		 */
		private $Winner;

		/**
		 * @return mixed
		 */
		public function getPlayerWeapon()
		{
			return $this->PlayerWeapon;
		}

		/**
		 * @param mixed $PlayerWeapon
		 */
		public function setPlayerWeapon($PlayerWeapon)
		{
			$this->PlayerWeapon = $PlayerWeapon;
		}

		/**
		 * @return mixed
		 */
		public function getAIWeapon()
		{
			return $this->AIWeapon;
		}

		/**
		 * @param mixed $AIWeapon
		 */
		public function setAIWeapon($AIWeapon)
		{
			$this->AIWeapon = $AIWeapon;
		}

		/**
		 * @return mixed
		 */
		public function getWinner()
		{
			return $this->Winner;
		}

		/**
		 * @param mixed $Winner
		 */
		public function setWinner($Winner)
		{
			$this->Winner = $Winner;
		}






	}