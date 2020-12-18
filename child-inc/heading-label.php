<?php
require_once ABSPATH . WPINC . '/class-wp-customize-control.php';

class Child_Customize_Heading extends WP_Customize_Control {
	public $type = 'info';
	public $label = '';
	public function render_content() {
		?>
			<h3 style="text-transform:uppercase;margin-top:2em;border-bottom:1px solid;">
				<?php echo $this->label ?>
			</h3>
		<?php
	}

}
//-----------------------------------------------------------------------------
?>