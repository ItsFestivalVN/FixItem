<?php

namespace ItsFestivalVN;

use pocketmine\player\Player;
use pocketmine\command\{Command, CommandSender};
use pocketmine\plugin\PluginBase as PB;
use pocketmine\event\Listener as L;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\{Pickaxe, Sword, Hoe, Axe, Armor, Shovel};

class FixItem extends PB implements L {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){
            case "fix":
                if(!$sender instanceof Player){
                    $sender->sendMessage("§l§c•§e Please use command in game");
                    return true;
                }
                $item = $sender->getInventory()->getItemInHand();
                if($item instanceof Pickaxe or $item instanceof Sword or $item instanceof Hoe or $item instanceof Axe or $item instanceof Shovel or $item instanceof Armor){
                    if($item->hasEnchantments()){
                        $cost = 10000; #Price For Enchanted Item
                        if(EconomyAPI::getInstance()->myMoney($sender) >= $cost){
                            EconomyAPI::getInstance()->reduceMoney($sender, $cost);
                            $item->setDamage(0);
                            $sender->getInventory()->setItemInHand($item);
                            $itemName = $item->getCustomName();
                            $sender->sendMessage("§6You Fixed Item§e ". $itemName ." §6With Price§e ". $cost ." §6Money");
                        }
                    }
                    else{
                        $cost = 5000; #Price For Normal Item
                        if(EconomyAPI::getInstance()->myMoney($sender) >= $cost){
                            EconomyAPI::getInstance()->reduceMoney($sender, $cost);
                            $item->setDamage(0);
                            $sender->getInventory()->setItemInHand($item);
                            $itemName = $item->getCustomName();
                            $sender->sendMessage("§6You Fixed Item§e ". $itemName ." §6With Price§e ". $cost ." §6Money");
                        } 
                    }
                }
                else{
                    $sender->sendMessage("§6You Need To Hold In Your Hand: Pickaxe, Sword, Shovel, Axe, Armor To Fix");
                }
            break;
        }
        return true;
    }
}