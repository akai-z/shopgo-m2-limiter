<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Sns notification observer
 */
class SnsNotification implements ObserverInterface
{
    /**
     * Limiter code
     */
    const CODE = 'ShopGo_Limiter';

    /**
     * Set SKU limit action
     */
    const ACTION_SET_SKU_LIMIT = 'set_sku_limit';

    /**
     * Set admin users
     */
    const ACTION_SET_ADMIN_USERS = 'set_admin_users';

    /**
     * Notifier model
     *
     * @var \ShopGo\Limiter\Model\Sku
     */
    protected $_skuLimiter;

    /**
     * Notifier data helper
     *
     * @var \ShopGo\Limiter\Helper\Data
     */
    protected $_helper;

    /**
     * @param \ShopGo\Limiter\Model\Sku $skuLimiter
     * @param \ShopGo\Limiter\Helper\Data $helper
     */
    public function __construct(
        \ShopGo\Limiter\Model\Sku $skuLimiter,
        \ShopGo\Limiter\Helper\Data $helper
    ) {
        $this->_skuLimiter = $skuLimiter;
        $this->_helper = $helper;
    }

    /**
     * Handle SNS notifications
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $notification = $observer->getEvent()->getData('notification');

        if ($notification['module'] != self::CODE) {
            return false;
        }

        switch ($notification['action']) {
            case self::ACTION_SET_SKU_LIMIT:
                $this->_skuLimiter->setLimit(
                    $notification['arguments']['sku_limit']
                );
                break;
            case self::ACTION_SET_ADMIN_USERS:
                $this->_helper->setAdminUsers(
                    $notification['arguments']['admin_users']
                );
                break;
        }
    }
}
