<?php
namespace Give\Form\Template;

use Give\FormAPI\Group;

/**
 * Class Options
 *
 * @since 2.7.0
 * @package Give\Form\Template
 */
class Options {
	/**
	 * Theme Options
	 *
	 * @since 2.7.0
	 * @var array
	 */
	public $groups = [];

	/**
	 * ThemeOptions constructor.
	 *
	 * @since 2.7.0
	 * @param $array
	 *
	 * @return Options
	 */
	public static function fromArray( $array ) {
		$options = new static();

		foreach ( $array as $id => $group ) {
			$group['id']       = $id;
			$options->groups[] = Group::fromArray( $group );
		}

		return $options;
	}

	/**
	 * Return array configuration for checkout label setting field.
	 *
	 * Note: if you want to add an option in template to overwrite "Donate Now" button title then instead of define it manually in template options, developer can call this function.
	 * This function help to maintain backward compatibility with legacy donation form renderer.
	 *
	 * @return array
	 */
	public static function getCheckoutLabelField() {
		return [
			'id'                 => 'checkout_label',
			'name'               => __( 'Submit Button', 'give' ),
			'desc'               => __( 'The button label for completing a donation.', 'give' ),
			'type'               => 'text_medium',
			'attributes'         => [
				'placeholder' => __( 'Donate Now', 'give' ),
			],
			'default'            => __( 'Donate Now', 'give' ),
			'mapToLegacySetting' => '_give_checkout_label',
		];
	}

	/**
	 * Return array configuration for display style setting field.
	 *
	 * Note: if you want to add an option in template to overwrite donation levels style then instead of define it manually in template options, developer can call this function.
	 * This function help to maintain backward compatibility with legacy donation form renderer.
	 *
	 * @return array
	 */
	public static function getDonationLevelsDisplayStyleField() {
		return [
			'name'               => __( 'Display Style', 'give' ),
			'description'        => __( 'Set how the donations levels will display on the form.', 'give' ),
			'id'                 => 'display_style',
			'type'               => 'radio_inline',
			'default'            => 'buttons',
			'options'            => [
				'buttons'  => __( 'Buttons', 'give' ),
				'radios'   => __( 'Radios', 'give' ),
				'dropdown' => __( 'Dropdown', 'give' ),
			],
			'wrapper_class'      => 'give-hidden _give_display_style_field',
			'mapToLegacySetting' => '_give_checkout_label',
		];
	}

	/**
	 * Return array configuration for display options setting field.
	 *
	 * Note: if you want to add an option in template to overwrite donation form display style then instead of define it manually in template options, developer can call this function.
	 * This function help to maintain backward compatibility with legacy donation form renderer.
	 *
	 * @return array
	 */
	public static function getDisplayOptionsField() {
		return [
			'name'          => __( 'Display Options', 'give' ),
			'desc'          => sprintf( __( 'How would you like to display donation information for this form?', 'give' ), '#' ),
			'id'            => 'payment_display',
			'type'          => 'radio_inline',
			'options'       => [
				'onpage' => __( 'All Fields', 'give' ),
				'modal'  => __( 'Modal', 'give' ),
				'reveal' => __( 'Reveal', 'give' ),
				'button' => __( 'Button', 'give' ),
			],
			'wrapper_class' => '_give_payment_display_field',
			'default'       => 'onpage',
		];
	}

	/**
	 * Return array configuration for continue to donation button label ( reveal label ) setting field.
	 *
	 * Note: if you want to add an option in template to overwrite reveal_label text then instead of define it manually in template options, developer can call this function.
	 * This function help to maintain backward compatibility with legacy donation form renderer.
	 *
	 * @return array
	 */
	public static function getContinueToDonationFormField() {
		return [
			'id'            => 'reveal_label',
			'name'          => __( 'Continue Button', 'give' ),
			'desc'          => __( 'The button label for displaying the additional payment fields.', 'give' ),
			'type'          => 'text_small',
			'attributes'    => [
				'placeholder' => __( 'Donate Now', 'give' ),
			],
			'wrapper_class' => '_give_reveal_label_field give-hidden',
		];
	}

	/**
	 * Return array configuration for float labels setting field.
	 *
	 * Note: if you want to add an option in template to overwrite float labels feature then instead of define it manually in template options, developer can call this function.
	 * This function help to maintain backward compatibility with legacy donation form renderer.
	 *
	 * @return array
	 */
	public static function getFloatLabelsField() {
		return [
			'name'    => __( 'Floating Labels', 'give' ),
			/* translators: %s: forms http://docs.givewp.com/form-floating-labels */
			'desc'    => sprintf( __( 'Select the <a href="%s" target="_blank">floating labels</a> setting for this GiveWP form. Be aware that if you have the "Disable CSS" option enabled, you will need to style the floating labels yourself.', 'give' ), esc_url( 'http://docs.givewp.com/form-floating-labels' ) ),
			'id'      => 'form_floating_labels',
			'type'    => 'radio_inline',
			'options' => [
				'global'   => __( 'Global Option', 'give' ),
				'enabled'  => __( 'Enabled', 'give' ),
				'disabled' => __( 'Disabled', 'give' ),
			],
			'default' => 'global',
		];
	}
}
