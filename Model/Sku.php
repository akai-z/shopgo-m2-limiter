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
     * @param \ShopGo\Limiter\Model\Config $config
     * @param \ShopGo\Limiter\Helper\Data $helper
     */
    public function __construct(
        \ShopGo\Limiter\Model\Config $config,
        \ShopGo\Limiter\Helper\Data $helper
    ) {
        $this->_config = $config;
        $this->_helper = $helper;
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
}
