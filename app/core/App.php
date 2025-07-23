<?php

namespace AppDAF\CORE;

use AppDAF\ENUM\ClassName;

class App
{

    private static array $dependencies;

  public static function getDependencie(ClassName $className): mixed
{
    self::$dependencies = yaml_parse_file('../app/config/services.yml');
    
    if (!is_array(self::$dependencies)) {
        throw new \Exception("Le fichier services.yml est introuvable ou mal formé");
    }
    
    if (!array_key_exists($className->value, self::$dependencies)) {
        throw new \Exception("La dependance {$className->value} est introuvable dans services.yml");
    }

    $class = self::$dependencies[$className->value];
    
    if (!method_exists($class, METHODE_INSTANCE_NAME)) {
        throw new \Exception("La méthode " . METHODE_INSTANCE_NAME . " n'existe pas dans la classe $class");
    }

    return $class::{METHODE_INSTANCE_NAME}();
}

}
