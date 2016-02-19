<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Model;

use Magento\Framework\Notification\MessageInterface;

class Config extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Config factory model
     *
     * @var \Magento\Config\Model\Config\Factory
     */
    protected $_configFactory;

    /**
     * @param \Magento\Config\Model\Config\Factory $configFactory
     */
    public function __construct(
        \Magento\Config\Model\Config\Factory $configFactory
    ) {
        $this->_configFactory = $configFactory;
    }

    /**
     * Get config model
     *
     * @param array $configData
     * @return \Magento\Config\Model\Config
     */
    protected function _getConfigModel($configData = [])
    {
        /** @var \Magento\Config\Model\Config $configModel  */
        $configModel = $this->_configFactory->create(['data' => $configData]);
        return $configModel;
    }

    /**
     * Get config data value
     *
     * @param string $path
     * @return string
     */
    public function getConfigData($path)
    {
        return $this->_getConfigModel()->getConfigDataValue($path);
    }

    /**
     * Set config data
     *
     * @param string $path
     * @param string|int|bool $value
     * @param null|string|bool|int|\Magento\Store\Api\Data\StoreInterface $store
     * @param null|string|bool|int|\Magento\Store\Api\Data\WebsiteInterface $website
     * @return bool
     */
    public function setConfigData($path, $value, $store = '', $website = '')
    {
        $result = false;
        $path   = explode('/', $path);

        try {
            $group = [
                $path[1] => [
                    'fields' => [
                        $path[2] => [
                            'value' => $value
                        ]
                    ]
                ]
            ];

            $configData = [
                'section' => $path[0],
                'website' => $website,
                'store'   => $store,
                'groups'  => $group
            ];

            $this->_getConfigModel($configData)->save();

            $result = true;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
        } catch (\Exception $e) {}

        return $result;
    }
}
