<?php

namespace LabCoding\Feedback\Action\Console;

use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Db\Adapter\Adapter;

class InitController extends AbstractConsoleController
{
    /**
     * @var Adapter
     */
    private $dbAdapter;

    /**
     * @var array
     */
    private $config;

    /**
     * InitController constructor.
     * @param Adapter $dbAdapter
     * @param array $config
     */
    public function __construct(Adapter $dbAdapter, array $config)
    {
        $this->dbAdapter = $dbAdapter;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function runAction()
    {
        if (!isset($this->config['entity_map']['Feedback']['table'])) {
            throw new \RuntimeException('entity_map config not found');
        }
        $table = $this->config['entity_map']['Feedback']['table'];

        $query = "CREATE TABLE IF NOT EXISTS `$table` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(50) DEFAULT NULL,
                    `email` VARCHAR(100) DEFAULT NULL,
                    `message` TEXT,
                    `answer` TEXT NULL,
                    `created_dt` DATETIME NOT NULL,
                    `updated_dt` DATETIME NOT NULL,
                    `status` TINYINT(1) DEFAULT 1, 
                    PRIMARY KEY (`id`) 
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        try {
            $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);

            return "Feedback module initialized successfully" . PHP_EOL;
        } catch (\Exception $e) {
            return
                $e->getMessage() . PHP_EOL .
                $e->getTraceAsString() . PHP_EOL;
        }
    }
}
