<?php

namespace repliedk;

use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\plugin\PluginBase;
use repliedk\command\CEnchantCommand;
use repliedk\object\CEnchantment;
use repliedk\object\Enchantment;

class CustomEnchants extends PluginBase {
    
    public static CustomEnchants $instance;
    public array $customEnchants;

    protected function onLoad(): void {
        self::$instance = $this;
        $this->saveDefaultConfig();
    }

    protected function onEnable(): void {
        $this->getServer()->getCommandMap()->register("cenchant", new CEnchantCommand("cenchant"));
        foreach ($this->getConfig()->get("enchantments") as $name => $data) {
            $this->registerEnchant($name, new EffectInstance(VanillaEffects::getAll()[$data["effect-id"]], 2 * 20, 1, false, false));
        }
    }

    protected function registerEnchant(string $name, EffectInstance $effectInstance): void {
        $this->customEnchants[$name] = new Enchantment($name, $effectInstance);
    }

    public function getEnchant(string $name): CEnchantment {
        return $this->customEnchants[$name] ?? null;
    }

    public static function getInstance(): CustomEnchants {
        return self::$instance;
    }

}