<?php

namespace Give\PaymentGateways\Stripe\Repositories;

use Give\Framework\Exceptions\Primitives\InvalidPropertyName;
use Give\PaymentGateways\Stripe\Models\AccountDetail as AccountDetailModel;
use Give\Framework\Exceptions\Primitives\DuplicateStripeAccountName;
use Give\Framework\Exceptions\Primitives\StripeAccountAlreadyConnected;
use function esc_html__;
use function give_get_option;
use function give_stripe_get_all_accounts;
use function give_update_option;

/**
 * Class Settings
 * @package GiveStripe\Settings\Repositories
 *
 * @unreleased
 */
class Settings {
	/**
	 * @unreleased
	 * @return array
	 */
	public function getAllStripeAccounts() {
		return give_stripe_get_all_accounts();
	}

	/**
	 * @unreleased
	 *
	 * @param int $formId
	 *
	 * @return bool|mixed|string
	 */
	public static function getDefaultStripeAccountSlugForDonationForm( $formId ) {
		return give()->form_meta->get_meta( $formId, '_give_stripe_default_account', true );
	}

	/**
	 * @unreleased
	 *
	 * @param int $formId
	 * @param $stripeAccountSlug
	 *
	 * @return bool
	 */
	public static function setDefaultStripeAccountSlugForDonationForm( $formId, $stripeAccountSlug ) {
		return give()->form_meta->update_meta( $formId, '_give_stripe_default_account', $stripeAccountSlug );
	}

	/**
	 * @unreleased
	 * @return string
	 */
	public function getDefaultStripeAccountSlug() {
		return give_stripe_get_default_account_slug();
	}

	/**
	 * @unreleased
	 * @return bool
	 */
	public function hasDefaultGlobalStripeAccountSlug() {
		return (bool) $this->getDefaultStripeAccountSlug();
	}

	/**
	 * @unreleased
	 *
	 * @param string $accountSlug
	 *
	 * @return bool
	 */
	public function setDefaultGlobalStripeAccountSlug( $accountSlug ) {
		return give_update_option( '_give_stripe_default_account', $accountSlug );
	}

	/**
	 * @unreleased
	 * @throws StripeAccountAlreadyConnected
	 * @throws DuplicateStripeAccountName|InvalidPropertyName
	 */
	public function addNewStripeAccount( AccountDetailModel $stripeAccount ) {
		$allAccounts = give_stripe_get_all_accounts();
		$accountSlug = $stripeAccount->accountSlug;

		if ( ! $this->isUniqueAccountName( $stripeAccount->accountName, $allAccounts ) ) {
			throw new DuplicateStripeAccountName( esc_html__( 'Stripe account already exist with same name.', 'give' ) );
		}

		if (
			array_key_exists( $accountSlug, $allAccounts ) ||
			$this->isAccountAlreadyConnected( $stripeAccount, $allAccounts )
		) {
			throw new StripeAccountAlreadyConnected( esc_html__( 'Stripe account already connected', 'give' ) );
		}

		$allAccounts[ $accountSlug ] = $stripeAccount->toArray();

		return give_update_option( '_give_stripe_get_all_accounts', $allAccounts );
	}

	/**
	 * @unreleased
	 */
	public function updateStripeAccount( AccountDetailModel $stripeAccount ) {
		$allAccounts = give_stripe_get_all_accounts();
		$accountSlug = $stripeAccount->accountSlug;

		if ( array_key_exists( $accountSlug, $allAccounts ) ) {
			$accountDetails = $stripeAccount->toArray();

			// account_id, account_slug  are unique value which used to reference to connect stripe account.
			// They can not be renamed.
			unset( $accountDetails['account_id'], $accountDetails['account_slug'] );

			$allAccounts[ $accountSlug ] = $stripeAccount->toArray();

			return give_update_option( '_give_stripe_get_all_accounts', $allAccounts );
		}

		return false;
	}

	/**
	 * @unreleased
	 *
	 * @param AccountDetailModel $stripeAccount
	 * @param array $allAccounts
	 *
	 * @return bool
	 * @throws InvalidPropertyName
	 */
	public function isAccountAlreadyConnected( AccountDetailModel $stripeAccount, $allAccounts ) {
		foreach ( $allAccounts as $account ) {
			$savedStripeAccount = AccountDetailModel::fromArray( $account );

			if (
				$savedStripeAccount->liveSecretKey === $stripeAccount->liveSecretKey &&
				$savedStripeAccount->livePublishableKey === $stripeAccount->livePublishableKey &&
				$savedStripeAccount->testSecretKey === $stripeAccount->testSecretKey &&
				$savedStripeAccount->testPublishableKey === $stripeAccount->testPublishableKey
			) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @unreleased
	 *
	 * @param string $stripeAccountName
	 * @param array $allAccounts
	 *
	 * @return bool
	 * @throws InvalidPropertyName
	 */
	public function isUniqueAccountName( $stripeAccountName, $allAccounts ) {
		foreach ( $allAccounts as $account ) {
			$savedStripeAccount = AccountDetailModel::fromArray( $account );

			if ( $savedStripeAccount->accountName === $stripeAccountName ) {
				return false;
			}
		}

		return true;
	}
}
