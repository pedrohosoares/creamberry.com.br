<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'creamberry' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'pedrohosoares' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '46302113' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '2A&>Nzj7QyBsjgjXo[l@3HohC NEB<Ys|%} aR0mK5m82qlID^#P!!;*&42w!T#W' );
define( 'SECURE_AUTH_KEY',  '.a9zm3&Ob-*uh[-mO0QwU2,a[/Ydf6JU*cSA/^VW@Yn*XRH[cry`P<A=V2ThI1_m' );
define( 'LOGGED_IN_KEY',    'v4QgsEa]%]CK6k>ySE/_iD^~h:hfmFfxNK-gDOJx]OjV3&>8hY$o%YEBW1<1@|~7' );
define( 'NONCE_KEY',        'o/}%+LjLC(|Hv<XS9A*AceEU80H>!@~R^u1:=}^Qem8;tVAyhxS+gJFH#J1y_w*w' );
define( 'AUTH_SALT',        'F%dKuQ[dfcKID&3&VqF}dbtq[Xz9MqGQq4!U2-Da299<.&D}BFsSG{UIq31R|-FE' );
define( 'SECURE_AUTH_SALT', 'qb YT4-.#e:h;okzxR#bP<d{Rif/|4;dFXp~N<C}gQ(oCiDH3|id)$k$H2E&pG3r' );
define( 'LOGGED_IN_SALT',   'qF~>4-8~A.ynYj9N3!02Hd/E$3nP#zl8f^KrbZ#WPfDG%sCSk$S7C%Tf2bt %|nr' );
define( 'NONCE_SALT',       '6L>`pK,e&u6lzLXg~+R`QD*II`!Qym~s.^#C]5BW6pG[(jalXSL?iLq@S4[N[}NW' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define('FS_METHOD', 'direct');

define('FS_METHOD', 'direct');

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
