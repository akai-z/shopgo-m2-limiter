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
use ShopGo\Limiter\Helper\DataFactory as LimiterHelperFactory;

/**
 * Set admin users
 */
class SetAdminUsers extends Command
{
    /**
     * Admin users argument
     */
    const ADMIN_USERS_ARGUMENT = 'admin_users';

    /**
     * @var State
     */
    private $_state;

    /**
     * @var LimiterHelperFactory
     */
    private $_limiterHelperFactory;

    /**
     * @param State $state
     * @param LimiterHelperFactory $limiterHelperFactory
     */
    public function __construct(
        State $state,
        LimiterHelperFactory $limiterHelperFactory
    ) {
        parent::__construct();
        $this->_state = $state;
        $this->_limiterHelperFactory = $limiterHelperFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $options = [
            new InputArgument(
                self::ADMIN_USERS_ARGUMENT,
                null,
                InputArgument::REQUIRED,
                'Limited admin users'
            )
        ];

        $this->setName('limiter:admin-users')
            ->setDescription('Add admin users')
            ->setDefinition($options);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = 'Could not add admin users!';
        $adminUsers = $input->getArgument(self::ADMIN_USERS_ARGUMENT);

        if (!is_null($adminUsers)) {
            $this->_state->setAreaCode('adminhtml');

            $result = $this->_limiterHelperFactory->create()->setAdminUsers($adminUsers);

            $result = $result
                ? 'Admin users have been set!'
                : 'Could not set admin user!';
        } else {
            throw new \InvalidArgumentException('Missing arguments.');
        }

        $output->writeln('<info>' . $result . '</info>');
    }
}
