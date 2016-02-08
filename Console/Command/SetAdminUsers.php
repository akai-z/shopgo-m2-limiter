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
 * Set admin users
 */
class SetAdminUsers extends Command
{
    /**
     * Admin users argument
     */
    const ADMIN_USERS_ARGUMENT = 'admin_users';

    /**
     * @var Config
     */
    private $_config;

    /**
     * @param Config $config
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
     * Set SKU limit
     *
     * @param string $content
     * @return string
     */
    protected function _setAdminUsers($content)
    {
        $result = false;

        try {
            $group = [
                'general' => [
                    'fields' => [
                        'admin_users' => [
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
        $result = 'Could not add admin users!';
        $adminUsers = $input->getArgument(self::ADMIN_USERS_ARGUMENT);

        if (!is_null($adminUsers)) {
            $this->_config->setAreaCode('adminhtml');

            $result = $this->_setAdminUsers($adminUsers);

            $result = $result
                ? 'Admin users have been set!'
                : 'Could not set admin user!';
        } else {
            throw new \InvalidArgumentException('Missing arguments.');
        }

        $output->writeln('<info>' . $result . '</info>');
    }
}
