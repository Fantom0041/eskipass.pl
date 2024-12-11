<?php
define('INSTALLATION', 1);
define('SITE_URL', getenv('SITE_URL') ?: 'https://eskipass.x-soft.it/');
define('SITE_NAME', 'eSkipass - karnety i ubezpieczenia na stoki narciarskie online');
define('SITE_DESC', 'Platforma sprzedaży karnetów narciarskich i ubezpieczeń narciarskich online.');
define('THEME', 'eskipass');
define('LANG', 24); //na sztywno PL


// ** MySQL settings ** //
/** MySQL database name */
define('DB_NAME', getenv('MYSQL_DATABASE') ?: 'stage_epass2');

/** MySQL database username */
define('DB_USER', getenv('MYSQL_USER') ?: 'stepass');

/** MySQL database password */
define('DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: 'plokKIJUHa19');

/** MySQL hostname */
define('DB_HOST', getenv('MYSQL_HOST') ?: 'localhost');

/** teenyCMS Database Table prefix. */
define('TABLE_PREFIX', 'ts_');

/** teenyCMS version. */
define('VER', '5.0');
?>
