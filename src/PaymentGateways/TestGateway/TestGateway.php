<?php

namespace Give\PaymentGateways\TestGateway;

use Give\Framework\PaymentGateways\Contracts\PaymentGateway;
use Give\Framework\PaymentGateways\PaymentGatewayTypes\OnSitePaymentGateway;
use Give\Helpers\Form\Utils as FormUtils;
use Give\PaymentGateways\TestGateway\Actions\PublishPaymentAndSendToSuccessPage;
use Give\PaymentGateways\TestGateway\Views\LegacyFormFieldMarkup;

/**
 * Class TestGateway
 * @unreleased
 */
class TestGateway extends PaymentGateway implements OnSitePaymentGateway {

	/**
	 * @inheritDoc
	 */
	public static function id() {
		return 'test-gateway';
	}

	/**
	 * @inheritDoc
	 */
	public function getId() {
		return self::id();
	}

	/**
	 * @inheritDoc
	 */
	public function getName() {
		return 'Test Gateway';
	}

	/**
	 * @inheritDoc
	 */
	public function getPaymentMethodLabel() {
		return 'Test Gateway';
	}

	/**
	 * @inheritDoc
	 */
	public function getLegacyFormFieldMarkup( $formId ) {
		if ( FormUtils::isLegacyForm( $formId ) ) {
			return false;
		}

		/** @var LegacyFormFieldMarkup $legacyFormFieldMarkup */
		$legacyFormFieldMarkup = give( LegacyFormFieldMarkup::class );

		return $legacyFormFieldMarkup();
	}

	/**
	 * @inheritDoc
	 */
	public function handleGatewayRequest( $donationId, $formData ) {
		/** @var PublishPaymentAndSendToSuccessPage $action */
		$action = give( PublishPaymentAndSendToSuccessPage::class );

		return $action( $donationId );
	}
}