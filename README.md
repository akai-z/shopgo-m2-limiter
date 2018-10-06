Limiter `[UNMAINTAINED]`
========================

## `Latest code can be found in develop branch.`

## Synopsis

TODO

## Overview

TODO

## Installation

Below, you can find two ways to install the limiter module.

### 1. Install via Composer (Recommended)
First, make sure that Composer is installed: https://getcomposer.org/doc/00-intro.md

Make sure that Packagist repository is not disabled.

Run Composer require to install the module:

    php <your Composer install dir>/composer.phar require shopgo/limiter:*

### 2. Clone the limiter repository
Clone the <a href="https://github.com/shopgo-magento2/limiter" target="_blank">limiter</a> repository using either the HTTPS or SSH protocols.

### 2.1. Copy the code
Create a directory for the limiter module and copy the cloned repository contents to it:

    mkdir -p <your Magento install dir>/app/code/ShopGo/Limiter
    cp -R <limiter clone dir>/* <your Magento install dir>/app/code/ShopGo/Limiter

### Update the Magento database and schema
If you added the module to an existing Magento installation, run the following command:

    php <your Magento install dir>/bin/magento setup:upgrade

### Verify the module is installed and enabled
Enter the following command:

    php <your Magento install dir>/bin/magento module:status

The following confirms you installed the module correctly, and that it's enabled:

    example
        List of enabled modules:
        ...
        ShopGo_Limiter
        ...

## Tests

TODO

## Contributors

Ammar (<ammar@shopgo.me>)

## License

[Open Source License](LICENSE.txt)
