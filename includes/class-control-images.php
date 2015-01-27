<?php
/**
 * Class to create a custom layout control
 */
class Image_Storefront_Control extends WP_Customize_Control {

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
		<label style="overflow: hidden; zoom: 1;">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

			<label style="width: 48%; float: left; margin-right: 3.8%; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-1.png', __FILE__ ); ?>" alt="Option 1" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="compact" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-1' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: right; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-2.png', __FILE__ ); ?>" alt="Option 2" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="expanded" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-2' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: left; text-align: center; clear: both; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-3.png', __FILE__ ); ?>" alt="Option 3" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="central" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-3' ); ?> />
				<br/>
			</label>
			<label style="width: 48%; float: right; text-align: center; margin-bottom: 1.618em;">
				<img src="<?php echo plugins_url( '../assets/img/admin/option-4.png', __FILE__ ); ?>" alt="Option 4" style="display: block; width: 100%; margin-bottom: .618em" />
				<input type="radio" value="inline" style="margin: 5px 0 0 0;"name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); checked( $this->value(), 'option-4' ); ?> />
				<br/>
			</label>
		</label>
		<?php
	}
}