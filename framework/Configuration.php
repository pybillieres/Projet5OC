<?php

namespace Framework;


class Configuration
{

  private static $parameters; //parametre qui stocke données de configuration

  // Renvoie la valeur d'un paramètre de configuration
  public static function get($name, $defaultValue = null)
  {
    if (isset(self::getParameters()[$name])) {
      $value = self::getParameters()[$name];
    } else {
      $value = $defaultValue;
    }
    return $value;
  }

  private static function getParameters()
  {
    if (self::$parameters == null) {
      $filePath = "Configuration/prod.ini";
      if (!file_exists($filePath)) {
        $filePath = "Configuration/dev.ini";
      }
      if (!file_exists($filePath)) {
        throw new \Exception("Aucun fichier de configuration trouvé");
      } else {
        self::$parameters = parse_ini_file($filePath);
      }
    }
    return self::$parameters;
  }
}
