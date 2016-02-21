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
     * Notifier model
     *
     * @var \ShopGo\Limiter\Model\Sku
     */
    protected $_skuLimiter;

    /**
     * @param \ShopGo\Limiter\Model\Sku $skuLimiter
     */
    public function __construct(\ShopGo\Limiter\Model\Sku $skuLimiter)
    {
        $this->_skuLimiter = $skuLimiter;
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
        }
    }
}
