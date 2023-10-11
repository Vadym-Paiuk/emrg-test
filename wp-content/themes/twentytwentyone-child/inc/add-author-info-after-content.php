<?php
	add_action( 'elementor/widgets/register', 'register_banner_widget' );
	function register_banner_widget( $widgets_manager ) {
		class Custom_Elementor_Widget extends \Elementor\Widget_Base {
			public function get_name() {
				return 'custom-elementor-widget';
			}
			
			public function get_title() {
				return 'Custom Elementor Widget';
			}
			
			public function get_icon() {
				return 'eicon-button';
			}
			
			public function get_categories() {
				return ['basic'];
			}
			
			protected function _register_controls() {
				$this->start_controls_section(
					'section_dynamic_content',
					[
						'label' => 'Dynamic Content',
					]
				);
				
				$this->add_control(
					'author_name',
					[
						'label' => 'Author Name',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Enter Author Name', TEXT_DOMAIN ),
						'label_block' => true,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				
				$this->add_control(
					'author_position',
					[
						'label' => 'Author Position',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Enter Author Position', TEXT_DOMAIN ),
						'label_block' => true,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				
				$this->add_control(
					'author_description',
					[
						'label' => esc_html__( 'Enter Author Description', TEXT_DOMAIN ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'placeholder' => esc_html__( 'Description', TEXT_DOMAIN ),
						'dynamic' => [
							'active' => true,
						],
					]
				);
				
				$this->add_control(
					'author_image',
					[
						'label' => esc_html__( 'Choose Image', TEXT_DOMAIN ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'dynamic' => [
							'active' => true,
						],
					]
				);
				
				$this->add_control(
					'author_url',
					[
						'label' => esc_html__( 'Link', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', TEXT_DOMAIN ),
						'dynamic' => [
							'active' => true,
						],
					]
				);
				
				$this->end_controls_section();
			}
			
			public function render() {
				$settings = $this->get_settings_for_display();
				
				echo '<p>' . __( 'Author Name: ', TEXT_DOMAIN ) . $settings['author_name'] . '</p>';
				echo '<p>' . __( 'Author Position: ', TEXT_DOMAIN ) . $settings['author_position'] . '</p>';
				echo '<p>' . __( 'Author Description: ', TEXT_DOMAIN ) . $settings['author_description'] . '</p>';
				echo '<p>' . __( 'Author Image: ', TEXT_DOMAIN ) . '<img src="' . $settings['author_image']['url'] . '"></p>';
				echo '<p>' . __( 'Author Url: ', TEXT_DOMAIN ) . '<a href="' . $settings['author_url']['url'] . '">Read full bio</a></p>';
			}
		}
		
		$widgets_manager->register( new \Custom_Elementor_Widget() );
		
	}
	
	add_action('show_user_profile', 'add_user_position_field');
	add_action('edit_user_profile', 'add_user_position_field');
	function add_user_position_field($user) {
		?>
		<h3><?php _e('Position', TEXT_DOMAIN); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="position"><?php _e('Position', TEXT_DOMAIN); ?></label></th>
				<td>
					<input type="text" name="position" id="position" value="<?php echo esc_attr(get_the_author_meta('position', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your position.', TEXT_DOMAIN); ?></span>
				</td>
			</tr>
		</table>
		<?php
	}
	
	add_action('personal_options_update', 'save_user_position_field');
	add_action('edit_user_profile_update', 'save_user_position_field');
	function save_user_position_field($user_id) {
		if (current_user_can('edit_user', $user_id)) {
			update_user_meta($user_id, 'position', sanitize_text_field($_POST['position']));
		}
	}
	
	add_filter('the_content', 'add_elementor_after_content');
	function add_elementor_after_content($content) {
		if (is_single()) {
			$content .= do_shortcode( '[elementor-template id="93"]' );
		}
		
		return $content;
	}
