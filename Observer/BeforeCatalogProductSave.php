<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Before catalog product save observer
 */
class BeforeCatalogProductSave implements ObserverInterface
{
    /**
     * SKU limiter model
     *
     * @var \ShopGo\Limiter\Model\Sku
     */
    protected $_skuLimiter;

    /**
     * App state
     *
     * @var \Magento\Framework\App\State
     */
    protected $_appState;

    /**
     * @param \ShopGo\Limiter\Model\Sku $skuLimiter
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        \ShopGo\Limiter\Model\Sku $skuLimiter,
        \Magento\Framework\App\State $appState
    ) {
        $this->_skuLimiter = $skuLimiter;
        $this->_appState = $appState;
    }

    /**
     * Prevent adding products if SKU limit is exceeded
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $isNew = $observer->getEvent()->getProduct()->isObjectNew();

        if ($this->_skuLimiter->isLimitExceeded($isNew)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Unable to save product. You have reached SKU limit')
            );
        }
    }
}
