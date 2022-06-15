<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
/*
fix1653354346-cartao-mb-inc.php
*/

class Fix1653355466 {
	private $config = '{
		"title":"Dados",
		"description":"Campos adicionais pertencente a cada post",
		"prefix":"fix1652977601",
		"domain":"fix1652977642",
		"class_name":"Fix1653355466",
		"context":"normal",
		"priority":"default",
		"cpt":"cartao",
		"fields":[
			{
				"type":"text",
				"label":"User ID",
				"id":"fix165335_user_id",
				"info": "<a href=\'__site_url__/wp-admin/user-edit.php?user_id=__user_id__\'>__user_id__</a>"
			},{
				"type":"text",
				"label":"Validade",
				"id":"fix165335_validade"
			},{
				"type":"text",
				"label":"Nome completo",
				"id":"fix165335_nome"
			},{
				"type":"text",
				"label":"Print",
				"id":"fix165335_print",
				"info": "<a href=\'__site_url__/cartao-pdf/user-edit.php?user_id=__user_id__\'>__user_id__</a>"
			}
		]
	}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?>


					--- 
					<?php 
					// $info = isset($this->field['info']);
					// echo $info; 

					// print_r($field);
					// echo $this->value( $field );
					?> 

				</td>

					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s" autocomplete="off">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )

		);
		// echo 'ggggg-'; =================
		$info = isset( $field['info'] ) ? $field['info'] : '';
		if($info){
			$info = preg_replace("/__user_id__/", $this->value( $field ), $info);
			$info = preg_replace("/__site_url__/", site_url(), $info);
			// $info = preg_replace("/__post_name__/", site_url(), $info);
			
			// echo $this->value( $field );
			echo $info;
			// echo "<pre>";
			// print_r($this);
			// print_r($post_id);
			// echo "</pre>";
		}
		// echo '-ggggg';
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}
	private function info( $field ) {
		return "zzz";
	}

}
new Fix1653355466;
