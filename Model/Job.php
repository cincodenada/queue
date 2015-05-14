<?php
/**
 * Job Model File
 *
 * Copyright (c) 2009-2012 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 5
 * CakePHP version 2.x
 *
 * @package    queue
 * @subpackage queue.models
 * @copyright  2009-2012 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://github.com/davidpersson/queue
 */

/**
 * Job Model Class
 *
 * @package    queue
 * @subpackage queue.models
 */
App::uses('Model', 'Model');
class Job extends Model {

/**
 * Database configuration to use. Before using this model be sure to
 * define at least a minimal connection in your database.php file:
 * {{{
 *   // ...
 *	'queue' => array('datasource' => 'beanstalkd')
 * }}}
 *
 * @var string
 * @access public
 */
	public $useDbConfig = 'queue';
	public $useTable = false;
	protected $_schema = array();

/**
 * Check to see if queue is online and accepts jobs.
 *
 * @param array $cached Pass `true` to enable cached responses.
 * @return boolean
 */
	function online($cached = false) {
		static $status;

		if ($cached && isset($status)) {
			return $status;
		}

        try {
            $DataSource = @ConnectionManager::getDataSource($this->useDbConfig);
        } catch (\InternalErrorException $e) {
            return false;
        }

		return $status = $DataSource && $DataSource->isConnected();
	}
}

?>