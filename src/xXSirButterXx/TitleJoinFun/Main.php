<?php

namespace xXSirButterXx\TitleJoinFun;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\event\player\PlayerJoinEvent as PJE;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getLogger()->info("Hello World!");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->reloadConfig();
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "tjoin":
				if(isset($args[0])){
					switch($args[0]){
						case "reload":
							if($sender->hasPermission("title.command")){
								$this->saveDefaultConfig();
								$this->reloadConfig();
							}else{
								$sender->sendMessage(C::GREEN . "[TJ] " . "You dont have permisssion.");
							}
						case "testtitle":
							if($sender->hasPermission("title.command")){
								$t = $this->getConfig()->get("Title");
								$t = str_replace("%p", $sender->getName(), $t);
								$t = str_replace("&", "§", $t);	
								$st = $this->getConfig()->get("Subtitle");
								$st = str_replace("%p", $sender->getName(), $st);
								$st = str_replace("&", "§", $st);
								$l = $this->getConfig()->get("Length");;
								$fi = $this->getConfig()->get("FadeIn");
								$fo = $this->getConfig()->get("FadeOut");
								$sender->addTitle($t, $st, $fi, $l, $fo);							
								
								return true;
							}else{
								$sender->sendMessage(C::GREEN . "[TJ] " . "You dont have permission.");
							}
						break;
						case "settitle":
							if($sender->hasPermission("title.command")){
								if(count($args) > 1){
									unset($args[0]);
									$title = implode(" ", $args);
									$this->getConfig()->set("Title", $title);
									$this->getConfig()->save();
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You set the title to $title");
									return true;
								}else{
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Usage: /tjoin settitle <msg>");
									return true;
								}
							}else{
								$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You dont have permission!");
								return true;
							}
							return true;
						break;
						case "setsubtitle":
							if($sender->hasPermission("title.command")){
								if(count($args) > 1){
									unset($args[0]);
									$subtitle = implode(" ", $args);
									$this->getConfig()->set("Subtitle", $subtitle);
									$this->getConfig()->save();
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Yo set the subtitle to $subtitle");
									return true;
								}else{
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Usage: /tjoin setsubtitle <msg>");
									return true;
								}
							}else{
								$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You dont have permission!");
								return true;
							}
							return true;
						break;
						case "setlength":
							if($sender->hasPermission("title.command")){
								if(count($args) >= 1){
									if(is_numeric($args[1])){
										$this->getConfig()->set("Length", $args[1]);
										$this->getConfig()->save();
										$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You set the length to $args[1]");
										return true;
									}else{
										$sender->sendMessage(C::GREEN . "[TJ] ". C::WHITE . "Invalid Number");
										return true;
									}
								}else{
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Usage: /tjoin setlength <number>");
									return true;
								}									
							return true;
							}
						break;				
						case "setfadeout":
							if($sender->hasPermission("title.command")){
								if(count($args) >= 1){
									if(is_numeric($args[1])){
										$this->getConfig()->set("FadeOut", $args[1]);
										$this->getConfig()->save();
										$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You set the fadeout to $args[1]");
										return true;
									}else{
										$sender->sendMessage(C::GREEN . "[TJ] ". C::WHITE . "Invalid Number");
										return true;
									}
								}else{
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Usage: /tjoin setfadeout <number>");
									return true;
								}									
							return true;
							}
						break;				
						case "setfadein":
							if($sender->hasPermission("title.command")){
								if(count($args) >= 1){
									if(is_numeric($args[1])){
										$this->getConfig()->set("FadeIn", $args[1]);
										$this->getConfig()->save();
										$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "You set the fadein to $args[1]");
										return true;
									}else{
										$sender->sendMessage(C::GREEN . "[TJ] ". C::WHITE . "Invalid Number");
										return true;
									}
								}else{
									$sender->sendMessage(C::GREEN . "[TJ] " . C::WHITE . "Usage: /tjoin setfadein <number>");
									return true;
								}									
							return true;
							}
						break;						
						case "help":
							if($sender->hasPermission("title.command")){
								$sender->sendMessage(C::GREEN . "-------====[" . C::RED . "HELP" . C::GREEN . "]====-------");
								$sender->sendMessage(C::GREEN . "- /tjoin settitle <title>");
								$sender->sendMessage(C::GREEN . "- /tjoin setsubtitle <subtitle>");
								$sender->sendMessage(C::GREEN . "- /tjoin setlength <number>");
								$sender->sendMessage(C::GREEN . "- /tjoin setfadein <number>");
								$sender->sendMessage(C::GREEN . "- /tjoin setfadeout <number>");
								$sender->sendMessage(C::GREEN . "- /tjoin help");
								$sender->sendMessage(C::GREEN . "- /tjoin info");
								$sender->sendMessage(C::GREEN . "- /tjoin reload");
							return true;
							}else{
								$sender->sendMesage("You dont have permission!");
								return true;
							}
						break;
						case "version":
							if($sender->hasPermission("title.command")){
								$sender->sendMessage(C::GREEN . "[TJ]" . C::WHITE . " TitleJoinFun 1.0.0 by xXSirButterXx");
							return true;
							}
						break;
				return true;
					
					}
				}else{
				return false;
				}
		}
		return true;
	}
	public function onTitle(PJE $event){
		$p = $event->getPlayer();
		$this->getServer()->getScheduler()->scheduleDelayedTask(new TitleTask($this, $p), 31);
	}
	public function onDisable(){
		$this->getLogger()->info("Bye");
	}
}