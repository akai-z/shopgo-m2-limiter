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
use Magento\Framework\App\State;
use ShopGo\Limiter\Model\SkuFactory as SkuLimiterFactory;

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
     * @var State
     */
    private $_state;

    /**
     * @var SkuLimiterFactory
     */
    private $_skuLimiterFactory;

    /**
     * @param State $state
     * @param SkuLimiter $skuLimiter
     */
    public function __construct(State $state, SkuLimiterFactory $skuLimiterFactory)
    {
        parent::__construct();
        $this->_state = $state;
        $this->_skuLimiterFactory = $skuLimiterFactory;
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
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = 'Could not set SKU limit!';
        $skuLimit = $input->getArgument(self::LIMIT_ARGUMENT);

        if (!is_null($skuLimit)) {
            $this->_state->setAreaCode('adminhtml');

            $result = $this->_skuLimiterFactory->create()->setLimit($skuLimit);

            $result = $result
                ? 'SKU limit has been set!'
                : 'Could not set SKU limit!';
        } else {
            throw new \InvalidArgumentException('Missing arguments.');
        }

        $output->writeln('<info>' . $result . '</info>');
    }
}
