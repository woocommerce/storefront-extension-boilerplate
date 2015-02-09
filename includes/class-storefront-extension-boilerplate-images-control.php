<?php
/**
 * Class to create a custom layout control
 */
class Storefront_Extension_Boilerplate_Images_Control extends WP_Customize_Control {

	public $type = 'radio';

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
		<div style="overflow: hidden; zoom: 1;">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

			<label style="width: 48%; float: left; margin-right: 3.8%; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-1.png', __FILE__ ); ?>" alt="Option 1" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="option-1" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-1' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: right; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-2.png', __FILE__ ); ?>" alt="Option 2" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="option-2" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-2' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: left; text-align: center; clear: both; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-3.png', __FILE__ ); ?>" alt="Option 3" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="option-3" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-3' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: right; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-4.png', __FILE__ ); ?>" alt="Option 4" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="option-4" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-4' ); ?> />
				<br/>
			</label>
		</div>
		<?php
	}
}