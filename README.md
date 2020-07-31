# Phone Pin Checker

![Codecov](https://img.shields.io/codecov/c/github/sandwave-io/phone-pin-checker?style=flat-square)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/sandwave-io/phone-pin-checker/CI?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/sandwave-io/phone-pin-checker?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/v/sandwave-io/phone-pin-checker?style=flat-square)
![Packagist Downloads](https://img.shields.io/packagist/dt/sandwave-io/phone-pin-checker?style=flat-square)

Verify generated PINs in order to implement your VIP phone support with Voys.

This package is based on the Voys API.

## Compatibility
* PHP `>7.1`
* Laravel `5.3 | ^6.0`

## How to use

* Add the package in to your project.
* Make sure the service provider is loaded.
* Route your Voys webhook to `GET https://yourapplication.app/phone-pin-checker`.
* Use the create route (`POST https://yourapplication.app/phone-pin-checker`) to generate a new code.
    * You can add a reference (for a customer for example) using the optional `reference` field.
* You can listen to the `Sandwave\PhonePinChecker\Events\PinOkay` event to check if the a pin has been entered successfully.