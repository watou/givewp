<?php
global $post;

use Give\Form\Theme;
use function Give\Helpers\Form\Theme\getActiveID;
use function Give\Helpers\Form\Theme\Utils\Admin\renderMetaboxSettings;

$activatedTheme   = getActiveID( $post->ID );
$registeredThemes = Give()->themes->getThemes();
?>
<div class="form_template_options_wrap inner-panel<?php echo $activatedTheme ? ' has-activated-theme' : ''; ?>">
	<strong class="templates-list-heading"><?php _e( 'Available Form Themes', 'give' ); ?></strong>
	<div class="templates-list">
		<?php
		/* @var Theme $theme */
		foreach ( $registeredThemes as $theme ) {
			$isActive = $activatedTheme === $theme->getID();

			printf(
				'<div class="theme-info %1$s" data-id="%2$s">
							<div class="template-image-container">
								<img class="template-image" src="%3$s"/>
							</div>
							<div class="action">
								<div class="template-name">%4$s <span class="badge">%5$s</span></div>
								<button class="button %7$s">%6$s</button>
							</div>
						</div>',
				$theme->getID() . ( $isActive ? ' active' : '' ),
				$theme->getID(),
				$theme->getImage(),
				$theme->getName(),
				__( 'active', 'give' ),
				$isActive ? __( 'Deactivate', 'give' ) : __( 'Activate', 'give' ),
				$isActive ? 'js-theme--deactivate' : 'js-theme--activate'
			);
		}
		?>
	</div>

	<div class="form-template-introduction">
		<p>
			<?php _e( 'What is a Form Theme?', 'give' ); ?>
		</p>
		<p class="give-field-description form-template-description"><?php _e( 'In GiveWP, a form theme is a collection of templates and stylesheets used to define then appearance and display of a donation form on your website. Each one comes with a different design, layout and feature. All you need to do is choose the one that suits your taste and requirements for your cause.Compatibility with add-ons and third party plugins depend on the theme chosen. Be sure to test your donation form before going live to ensure smooth sailing!', 'give' ); ?></p>

		<div class="form-template-notice give-notice notice notice-success inline">
			<p>
				<?php _e( 'More themes are coming soon!', 'give' ); ?><br>
				<?php _e( 'Let us know what you want to see next', 'give' ); ?>
			</p>
			<button class="button"><?php _e( 'Take the Survey', 'give' ); ?></button>
		</div>
	</div>

	<div class="form-template-options-introduction">
		<strong>
			<?php _e( 'Form Theme Options', 'give' ); ?>
		</strong>
		<p class="give-field-description"><?php _e( 'Customize the appearance of your form theme by modifying the options below. You can preview your changes using "Preview button at anytime."', 'give' ); ?></p>
	</div>

	<div class="form-template-options">
		<?php
		/* @var Theme $theme */
		foreach ( $registeredThemes as $theme ) {
			printf(
				'<div class="theme-options %1$s" data-id="%2$s">%3$s</div>',
				$theme->getID() . ( $activatedTheme === $theme->getID() ? ' active' : '' ),
				$theme->getID(),
				renderMetaboxSettings( $theme )
			);
		}
		?>
	</div>
</div>
