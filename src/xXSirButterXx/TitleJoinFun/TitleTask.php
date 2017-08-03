<?php

namespace xXSirButterXx\TitleJoinFun;

use pocketmine\scheduler\PluginTask;
use pocketmine\Player;

class TitleTask extends PluginTask{
	private $main;
	
	public function __construct(Main $main, Player $player){
		parent::__construct($main, $player);
		
		$this->main = $main;
		
		$this->player = $player;
		
	}

	public function onRun(int $ct){
		$t = $this->main->getConfig()->get("Title");
        $t = str_replace("%p", $this->player->getName(), $t);
		$t = str_replace("&", "§", $t);
		
		$st = $this->main->getConfig()->get("Subtitle");
		$st = str_replace("%p", $this->player->getName(), $st);
		$st = str_replace("&", "§", $st);
		$l = $this->main->getConfig()->get("Length");;
		$fi = $this->main->getConfig()->get("FadeIn");
		$fo = $this->main->getConfig()->get("FadeOut");
		
		$this->player->addTitle($t, $st, $fi, $l, $fo);

		

	}
}