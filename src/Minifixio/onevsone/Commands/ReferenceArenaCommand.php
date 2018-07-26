<?php

namespace Minifixio\onevsone\Commands;

use pocketmine\command\{CommandSender, Command};
use pocketmine\level\Location;
use pocketmine\{Server, Player};
use pocketmine\utils\TextFormat;
use Minifixio\onevsone\{ArenaManager, OneVsOne};

/**
 * Command to reference a new Arena in the pool 
 * @author Minifixio
 */
class ReferenceArenaCommand extends Command {

	private $plugin;
	private $arenaManager;
	public $commandName = "refarena";

	public function __construct(OneVsOne $plugin, ArenaManager $arenaManager){
		parent::__construct($this->commandName, "Reference a new arena");
		$this->setUsage("/$this->commandName");
		$this->command = $this->commandName;
		
		$this->plugin = $plugin;
		$this->arenaManager = $arenaManager;
	}

	public function execute(CommandSender $sender, string $label, array $params){
		if(!$this->plugin->isEnabled()){
			return false;
		}

		if(!$sender instanceof Player){
			$sender->sendMessage(OneVsOne::getMessage("console_only"));
			return true;
		}
		
		if($sender->hasPermission("onevsone.refarena")){
		
		// Get current op location
		$playerLocation = $sender->getLocation();
		
		$this->plugin->getLogger()->info("location" . $sender->getLocation());
		
		// Add the arena
		$this->arenaManager->referenceNewArena($playerLocation);
		
		// Notify the op
		$sender->sendMessage(str_replace("{arenacount}", ($this->arenaManager->getNumberOfArenas() . TextFormat::RESET . OneVsOne::getMessage("pluginprefix "). OneVsOne::getMessage("arena_created"))));
		
		return true;
		}
		
		else{
			$sender->sendMessage(OneVsOne::getMessage("op_only"));
		}
	}
}