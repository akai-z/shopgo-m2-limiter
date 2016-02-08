<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Limiter\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ShopGo\Limiter\Model\Config;

/**
 * Set SKU limit
 */
class SetSkuLimit extends Command
{
    /**
     * SKU limit argument
     */
    const LIMIT_ARGUMENT = 'limit';

    /**
     * @var Config
     */
    private $_config;

    /**
     * @param Config $config
     * @param SkuLimiter $skuLimiter
     */
    public function __construct(Config $config) {
        parent::__construct();
        $this->_config = $config;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $options = [
            new InputArgument(
                self::LIMIT_ARGUMENT,
                null,
                InputArgument::REQUIRED,
                'SKU limit'
            )
        ];

        $this->setName('limiter:sku-limit')
            ->setDescription('Set SKU limit')
            ->setDefinition($options);

        parent::configure();
    }

    /**
     * Set SKU limit
     *
     * @param string $content
     * @return string
     */
    protected function _setLimit($content)
    {
        $result = false;

        try {
            $group = [
                'sku' => [
                    'fields' => [
                        'limit' => [
                            'value' => $content
                        ]
                    ]
                ]
            ];

            $configData = [
                'section' => 'limiter',
                'website' => null,
                'store'   => null,
                'groups'  => $group
            ];

            $result = $this->_config->setConfigData($configData);

            $result = true;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $messages = explode("\n", $e->getMessage());

            foreach ($messages as $message) {
                $result .= "\n" . $message;
            }
        } catch (\Exception $e) {
            $result .= "\n" . $e->getMessage();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = 'Could not set SKU limit!';
        $skuLimit = $input->getArgument(self::LIMIT_ARGUMENT);

        if (!is_null($skuLimit)) {
            $this->_config->setAreaCode('adminhtml');

            $result = $this->_setLimit($skuLimit);

            $result = $result
                ? 'SKU limit has been set!'
                : 'Could not set SKU limit!';
        } else {
            throw new \InvalidArgumentException('Missing arguments.');
        }

        $output->writeln('<info>' . $result . '</info>');
    }
}
