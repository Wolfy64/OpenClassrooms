<?php

class Wizard extends Character{
	
	public function bewitched(Character $person){
		// Avant tout : vérifier qu'on ne s'endort pas soi-même.
		if($person->getId() == $this->id){
			// Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.
			return self::ITS_ME_SPELL;
		}else{
			if ($this->getAsset() > 0){
				// On indique au personnage ensorceler le temps a dormir.
				$sleep = time() + ($this->getAsset() * 6 * 3600);

				$person->setSleepTime($sleep);

				return self::CHARACTER_WITCHED;
			} else{
				return self::NO_SPELL;
			}
		}
	}

}