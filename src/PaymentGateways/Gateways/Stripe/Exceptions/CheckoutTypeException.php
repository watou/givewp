<?php

namespace Give\PaymentGateways\Gateways\Stripe\Exceptions;

use Give\Framework\PaymentGateways\Exceptions\PaymentGatewayException;

/**
 * @unreleased
 */
class CheckoutTypeException extends PaymentGatewayException
{
    public function __construct($type, $code = 0, $previous = null)
    {
        parent::__construct("Checkout type '$type' is not supported", $code, $previous);
    }
}
