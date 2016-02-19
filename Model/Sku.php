<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Model;

class Sku extends \Magento\Framework\Model\AbstractModel
{
    /**
     * SKU limit xml path
     */
    const XML_PATH_SKU_LIMIT = 'limiter/sku/limit';

    /**
     * Product model
     *
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * Config model
     *
     * @var \ShopGo\Limiter\Model\Config
     */
    protected $_config;

    /**
     * Helper data
     *
     * @var \ShopGo\Limiter\Helper\Data
     */
    protected $_helper;

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param \ShopGo\Limiter\Model\Config $config
     * @param \ShopGo\Limiter\Helper\Data $helper
     */
    public function __construct(
        \Magento\Catalog\Model\Product $product,
        \ShopGo\Limiter\Model\Config $config,
        \ShopGo\Limiter\Helper\Data $helper
    ) {
        $this->_product = $product;
        $this->_config  = $config;
        $this->_helper  = $helper;
    }

    /**
     * Get products size
     *
     * @return int
     */
    protected function _getProductsSize()
    {
        return $this->_product->getCollection()->getSize();
    }

    /**
     * Get SKU limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->_config->getConfigData(self::XML_PATH_SKU_LIMIT);
    }

    /**
     * Set SKU limit
     *
     * @param int $limit
     * @return bool
     */
    public function setLimit($limit)
    {
        return $this->_config->setConfigData(self::XML_PATH_SKU_LIMIT, $limit);
    }

    /**
     * Check whether SKU limit is exceeded
     *
     * @param boolean $isNew
     * @return boolean
     */
    public function isLimitExceeded($isNew = false)
    {
        $isLimitExceeded = false;

        if (!$this->_helper->isEnabled() || !$this->_helper->isAdminAffected()) {
            return $isLimitExceeded;
        }

        $productSize = $isNew
            ? $this->_getProductsSize() + 1
            : $this->_getProductsSize();

        if ($productSize > $this->getLimit()) {
            $isLimitExceeded = true;
        }

        return $isLimitExceeded;
    }
}
