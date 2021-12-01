<?php

/**
 * Plugin Name:       Soares Show Api
 * Plugin URI:        https://encontreseuplugin.com.br/soares-put-in-content
 * Description:       Show franchise in api
 * 1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pedro Soares
 * Author URI:        https://www.linkedin.com/in/pedro-soares-27657756/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       soares-show-api
 * Domain Path:       /languages
 */

add_action( 'rest_api_init', function () {
	  register_rest_route( 
      'soares_show/v2', 
        's/(?P<id>\d+)', 
        array(
	        'methods' => 'GET',
	        'callback' => 'mostra_franquias_soares',
          'permission_callback' => '__return_true',
    	)  
    );
  } 
);

function get_localizacao($ID){
  $html = '';
  $taxonomies = wp_get_post_terms($ID, 'soares_show_localizacao',  array("fields" => "names"));
  foreach($taxonomies as $i=>$v):
    $html .= "<td>".$v."</td>";
  endforeach;
  return $html;
}
function creamberry_fields($ID){
  $html = "<td>".get_field('telefone_soares',$ID)."</td>";
  $html .= "<td>".get_field('email_soares',$ID)."</td>";
  $html .= "<td>".get_field('numero_soares',$ID)."</td>";
  $html .= get_localizacao($ID);
  return $html;
}
function acquazero_fields($ID){
  $html .= "<td>".get_field('logradouro',$ID)."</td>";
  $html .= "<td>".get_field('numero',$ID) ? ', ' . get_field('numero',$ID) : ''."</td>";
  $html .= "<td>".get_field('complemento') ? ', ' . get_field('complemento',$ID) : ''."</td>";
  $html .= "<td>".get_field('bairro',$ID) ? ', ' . get_field('bairro',$ID) : ''."</td>";
  $html .= "<td>".get_field('cidade',$ID) ? ', ' . get_field('cidade',$ID)['city_name'] . ' - ' . get_field('cidade',$ID)['state_id'] : ''."</td>";
  $html .= "<td>".get_field('telefone',$ID)."</td>";
  $html .= "<td>".get_field('e-mail',$ID)."</td>";
  $html .= "<td>".get_field('facebook',$ID)."</td>";
  $html .= "<td>".get_field('instagram',$ID)."</td>";
  $html .= "<td>".get_field('twitter',$ID)."</td>";
  $html .= "<td>".get_field('linkedin',$ID)."</td>";
  $html .= get_localizacao($ID);
  return $html;
}
function suav_fields($ID){
  $html .= "<td>".get_field('whatsapp',$ID)."</td>";
  $html .= "<td>".get_field('telefone',$ID)."</td>";
  $html .= "<td>".get_field('e-mail',$ID)."</td>";
  $html .= "<td>".get_field('n_endereco',$ID)."</td>";
  $html .= get_localizacao($ID);
  return $html;
}
function normal_fields($ID){
  $telefone = get_post_meta($ID, 'telefone_soares' );
  $email = get_post_meta( $ID,'email_soares' );
  $home_open = get_post_meta( $ID,'hour_open_soares' );
  $facebooksoares = get_post_meta( $ID,'facebook_soares');
  $instagramsoares = get_post_meta( $ID,'instagram_soares');
  $numero_soares = get_post_meta( $ID,'numero_soares');
  $html = '';
  $html .= '<td>'.(isset($telefone[0])?$telefone[0]:'').'</td>';
  $html .= '<td>'.(isset($email[0])?$email[0]:'').'</td>';
  $html .= '<td>'.(isset($home_open[0])?$home_open[0]:'').'</td>';
  $html .= '<td>'.(isset($facebooksoares[0])?$facebooksoares[0]:'').'</td>';
  $html .= '<td>'.(isset($instagramsoares[0])?$instagramsoares[0]:'').'</td>';
  $html .= '<td>'.(isset($numero_soares[0])?$numero_soares[0]:'').'</td>';
  $html .= get_localizacao($ID);
  return $html;
}

function mostra_franquias_soares(WP_REST_Request $r){
  header("Access-Control-Allow-Origin: *");
	$page = (isset($r['id']) and $r['id'] >0)?$r['id']:1;
	$offset = $page * $r['offset'];
	$domain = get_site_url();
  $post_type = strpos($domain,'acquazero')?'unidade':"soaresshow";
  $posts = get_posts(array(
		'post_type'=>$post_type,
		'numberposts'=>-1,
    'orderby' => 'date',
    'order' => 'DESC',
    'offset'=>0
	));
	$html = '';
	foreach($posts as $i=>$p):
    $html .= "<tr>";
		$html .= "<td>".$p->ID."</td>";
		$html .= "<td>".$p->post_title."</td>";
    if(strpos($domain,'acquazero')){
		  $html .= acquazero_fields($p->ID);
    }
    if(strpos($domain,'suav')){
		  $html .= suav_fields($p->ID);
    }
    if(strpos($domain,'quisto')){
		  $html .= normal_fields($p->ID);
    }
    if(strpos($domain,'creamberry')){
		  $html .= creamberry_fields($p->ID);
    }
		$html .= "</tr>";
	endforeach;
	echo $html;
	exit;
}
