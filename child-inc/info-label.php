<?php
require_once ABSPATH . WPINC . '/class-wp-customize-control.php';

class Child_Customize_Info extends WP_Customize_Control {
	public $type = 'info';
	public $label = '';
	public function render_content() {
		?>
			<p>
				<?php echo $this->label; ?>
			</p>
		<?php
	}

}
//-----------------------------------------------------------------------------
?>