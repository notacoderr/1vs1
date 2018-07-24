<?php

namespace Minifixio\onevsone\model;

use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;


class SignRefreshTask extends Task{
	
	/** var ArenaManager **/
	public $arenaManager;
	
	public function onRun(int $currentTick): void{
		$this->arenaManager->refreshSigns();
	}
	
}