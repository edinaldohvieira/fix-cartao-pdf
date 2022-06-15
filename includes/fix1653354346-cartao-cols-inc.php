<?php
/*
fix1653354346-cartao-cols-inc.php
*/
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'manage_cartao_posts_columns', 'fix1654293743' );
function fix1654293743( $columns ) {
	$columns = array(
		'cb' => $columns['cb'],
		'title' => 'key',
		'fix165335_user_id' => 'User ID',
		'fix165335_validade' => 'Validade',
		'fix165335_nome' => 'Nome completo',
	);
	return $columns;

}

add_action( 'manage_cartao_posts_custom_column', 'fix1654293915', 10, 2);
function fix1654293915( $column, $post_id ) {
	if ( 'fix165335_user_id' === $column ) {
		$fix165335_user_id = get_post_meta( $post_id, 'fix165335_user_id', true );
		echo $fix165335_user_id;
	}
	if ( 'fix165335_validade' === $column ) {
		$fix165335_validade = get_post_meta( $post_id, 'fix165335_validade', true );
		echo $fix165335_validade;
	}
	if ( 'fix165335_nome' === $column ) {
		$fix165335_nome = get_post_meta( $post_id, 'fix165335_nome', true );
		echo $fix165335_nome;
	}

}