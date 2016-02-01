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
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * @var \ShopGo\Limiter\Model\Config
     */
    protected $_config;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \ShopGo\Limiter\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \ShopGo\Limiter\Model\Config $config
    ) {
        $this->_authSession = $authSession;
        $this->_config = $config;

        parent::__construct($context);
    }

    /**
     * Get admin users on which limiter rules apply on
     *
     * @return array
     */
    protected function _getAdminUsers()
    {
        $users = $this->_config->getConfigData(self::XML_PATH_GENERAL_ADMIN_USERS);
        return array_map('trim', explode(',', $users));
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
     * Check whether limiter rules are applied on current admin user
     *
     * @return boolean
     */
    public function isAdminAffected()
    {
        $admin  = $this->_authSession->getUser()->getUsername();
        $admins = array_flip($this->_getAdminUsers());

        return isset($admins[$admin]);
    }
}
