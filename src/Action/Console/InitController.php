<?php

namespace T4web\Log\Action\Console;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter as DbAdapter;
use T4web\Migrations\Exception\RuntimeException;

class InitController extends AbstractActionController
{
    /**
     * @var DbAdapter
     */
    private $dbAdapter;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function onDispatch(MvcEvent $e)
    {
        if (!$e->getRequest() instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        $query = "CREATE TABLE IF NOT EXISTS `logs` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `message` VARCHAR(300) DEFAULT NULL,
              `scope` TINYINT NOT NULL,
              `priority` TINYINT NOT NULL,
              `extras` TEXT DEFAULT NULL,
              `created_dt` datetime NOT NULL,
              `updated_dt` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        try {
            $this->dbAdapter->query($query, DbAdapter::QUERY_MODE_EXECUTE);
        } catch (\Exception $e) {
            // currently there are no db-independent way to check if table exists
            // so we assume that table exists when we catch exception
        }
    }
}
