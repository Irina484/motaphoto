<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'motaphoto' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'marie' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '_)-_;vT?6>|4O4fH.&Gk&BhsSz3qT/+8Y>JA5Ul,3}0zU^.B_n)*eF!Ym6l1;sL(' );
define( 'SECURE_AUTH_KEY',  '=Z`LRoM5;0VvTT(X8!{(&<!)<X>o^aUp.w@iccxV!fW~~Mcn3}),j=d,3.~YGNN%' );
define( 'LOGGED_IN_KEY',    'ub+qX9YN[zY)Er?MB]-&T34rYov|biL0e4(l@t-(COx5Cl`Xy/ok JaDmL;4Cf-)' );
define( 'NONCE_KEY',        '49cu^j6lDbnKM2?3anJv];H-)FYD&V8`.e@0=(3`[Br./,y%]8Co@@(5t?G#QmDn' );
define( 'AUTH_SALT',        'GZ8!(DUW!V1V#:S~ yiliNb}hG;5[`Ib7,Lq6vEW~X&$q8$+Smr_} !B5pQSd,%b' );
define( 'SECURE_AUTH_SALT', 'KqHaR.J*+<izF`q||cw6fkL?lWj#jDk?]T#m/ua+9N3(}H92Wm:1vkVk64&21HnL' );
define( 'LOGGED_IN_SALT',   '%Oc-~N9Ij<On|+javfg,-bnTc<xTuOd~dv]f=|A5pH6@`i39dy5kE{.vV:D)of?+' );
define( 'NONCE_SALT',       'h~_2hpp$#?At#^C%AMS<D2kG;1.|MCc6bvb3HW169Pw^SumriF3sIXk=Ld-pAZU&' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
// Activer le mode débogage
define('WP_DEBUG', true);

// Enregistrer les erreurs dans un fichier log
define('WP_DEBUG_LOG', true);

// Désactiver l'affichage des erreurs à l'écran
define('WP_DEBUG_DISPLAY', false);

// Empêcher PHP d'afficher les erreurs directement à l'écran
@ini_set('display_errors', 0);


/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
