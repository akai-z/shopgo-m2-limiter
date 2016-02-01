<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * General enabled xml path
     */
    const XML_PATH_GENERAL_ENABLED = 'limiter/general/enabled';

    /**
     * General admin users xml path
     */
    const XML_PATH_GENERAL_ADMIN_USERS = 'limiter/general/admin_users';

    /**
     * @var \ShopGo\Limiter\Model\Config
     */
    protected $_config;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \ShopGo\Limiter\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \ShopGo\Limiter\Model\Config $config
    ) {
        $this->_config = $config;
        parent::__construct($context);
    }

    /**
     * Check whether limiter is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->_config->getConfigData(self::XML_PATH_GENERAL_ENABLED);
    }

    /**
     * Get admin users on which limiter rules apply on
     *
     * @return boolean
     */
    public function getAdminUsers()
    {
        return $this->_config->getConfigData(self::XML_PATH_GENERAL_ADMIN_USERS);
    }
}
