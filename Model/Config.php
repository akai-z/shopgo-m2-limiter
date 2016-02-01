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
     * App state
     *
     * @var \Magento\Framework\App\State
     */
    protected $_appState;

    /**
     * @param \Magento\Config\Model\Config\Factory $configFactory
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magento\Framework\App\State $appState
    ) {
        $this->_configFactory = $configFactory;
        $this->_appState = $appState;
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
     * @param array $configData
     */
    public function setConfigData($configData = [])
    {
        $this->_getConfigModel($configData)->save();
    }

    /**
     * Set area code
     *
     * @param string $code
     */
    public function setAreaCode($code)
    {
        $this->_appState->setAreaCode($code);
    }
}
