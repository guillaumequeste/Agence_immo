Autoloader:
  - getcomposer.org/download
  - dans le terminal, dans le dossier : php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  - l'option opsenssl doit être activée (voir page phpinfo)
    si elle n'est pas activée -> fichier de configuration de php (php.ini)
    -> décommenter extension=openssl (enlever le ; devant) (pour windows)
    -> sauvegarder le fichier en tant qu'administrateur
    -> réexécuter la ligne de code
  - un fichier composer-setup.php a été créé
  - dans le terminal : php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    -> installer verified
  - dans le terminal : php composer-setup.php
    -> création d'un fichier composer.phar
  - dans le terminal : php -r "unlink('composer-setup.php');"
    -> supprime le fichier composer-setup.php
  - on va utiliser le fichier composer.phar pour générer l'autoloader et plus tard télécharger des librairies
  - dans le terminal : php composer.phar
    -> il nous affiche les options disponibles
  - dans le terminal : php composer.phar init
    -> package name : gui/site
    -> description: ...
    -> author : ...
    -> minimum stability : ...
    -> package type : ...
    -> license : ...
    -> Would you like to define your dependencies (require) interactively [yes]? no
    -> Would you like to define your dev dependencies (require-dev) interactively [yes]? no
    -> Do you confirm generation [yes]? yes
    -> Would you like the vendor directory added to your .gitignore [yes]? (oui ou non)
  - un fichier composer.json a été créé
  - "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    },
    -> on lui dit que App\ correspond au dossier src
  - dans le terminal : php composer.phar dump-autoload
    -> crée un fichier autoload.php dans un dossier vendor
  - dans le fichier livre.php, on fait : require 'vendor/autoload.php'
    -> php va essayer dynamiquement de chercher où se trouve la classe désirée et de l'importer
    -> attention, pour que ça marche, il faut bien mettre le namespace au début de chaque classe
      ex : Text.php -> namespace App\Helpers;
  - plugin PHP namespace resolver -> clic droit sur la classe -> import class

  Résumé autoloader :
  1 - générer le fichier autoload.php
  2 - indiquer dans la classe le namespace qui correcpond au chemin du fichier
  3 - dans le fichier index.php, par exemple, require autoload.php et use le chemin vers la classe
    ex : Text.php -> namespace App\Helpers;
         index.php -> require '../vendor/autoload.php';
                   -> use App\Helpers\Text;
