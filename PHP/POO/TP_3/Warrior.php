<?php

class Warrior extends Character{

	public function getHit(){
		// On augmente de 5 les dégâts.
		$this->damages += 5 - $this->getAsset();
		// Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
		if($this->damages >= 100){
			return self::CHARACTER_KILL;
		// Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.
		}else{
			return self::CHARACTER_HIT;
		}
	}
}