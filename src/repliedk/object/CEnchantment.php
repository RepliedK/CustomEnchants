<?php

namespace repliedk\object;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\item\enchantment\Enchantment as EnchantmentEnchantment;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Rarity;
use pocketmine\player\Player;

abstract class CEnchantment extends EnchantmentEnchantment {

    public function __construct(string $name, public EffectInstance $effect){
        parent::__construct($name, Rarity::COMMON, ItemFlags::ARMOR, ItemFlags::NONE, 2);
    }
    
    public function giveEffect(Player $player): void {
        $player->getEffects()->add($this->effect);
    }

}

class Enchantment extends CEnchantment {}