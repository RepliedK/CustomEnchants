<?php

namespace repliedk\command;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use repliedk\CustomEnchants;

class CEnchantCommand extends VanillaCommand
{

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player)
            return;
        if (!$sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)) {
            $sender->sendMessage(TextFormat::colorize("&cYou do not have permission to use this command"));
            return;
        }    
        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::colorize("&c/cenchant [string: enchantName] or /cenchant list"));
            return;
        }
        if ($args[0] === "list") {
            $sender->sendMessage(TextFormat::colorize("&aEnchantments list: ".implode(":", CustomEnchants::getInstance()->customEnchants)));
        }
        if (!is_string($args[0])) {
            $sender->sendMessage(TextFormat::colorize("&cInvalid Name"));
            return;
        }
        if (($enchantment = CustomEnchants::getInstance()->getEnchant($args[0])) === null) {
            $sender->sendMessage(TextFormat::colorize("&cThis enchantment does not exist"));
            return;
        }
        $item = clone $sender->getInventory()->getItemInHand();
        if ($item->isNull()) {
            $sender->sendMessage(TextFormat::colorize("&cThis item is null"));
            return;
        }
        if ($item->hasEnchantment($enchantment)) {
            $sender->sendMessage(TextFormat::colorize("&cThe item already contains this enchantment"));
            return;
        }
        $lore = $item->getLore();
        $lore[] = TextFormat::colorize("&6" . $enchantment->getName());
        $item->setLore($lore);
        $item->addEnchantment(new EnchantmentInstance($enchantment, $enchantment->getMaxLevel()));
        $sender->getInventory()->setItemInHand($item);
        $sender->sendMessage(TextFormat::colorize("&aYou have successfully enchanted the item"));
    }

}