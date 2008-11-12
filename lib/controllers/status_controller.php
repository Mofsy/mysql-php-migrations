<?php
/**
 * This file houses the MpmStatusController class.
 *
 * @package    mysql_php_migrations
 * @subpackage Controllers
 * @license    http://www.opensource.org/licenses/bsd-license.php  The New BSD License
 * @link       http://code.google.com/p/mysql-php-migrations/
 */

/**
 * The MpmStatusController is used to display the latest migration.
 *
 * @package    mysql_php_migrations
 * @subpackage Controllers
 */
class MpmStatusController extends MpmController
{
	
	/**
	 * Determines what action should be performed and takes that action.
	 *
	 * @return void
	 */
	public function doAction()
	{
		// make sure we're init'd
		$this->checkIfReady();
		
		// need a pdo object
		$pdo = MpmDb::getPdo();
		
		// get latest timestamp
		$latest = MpmMigrationHelper::getCurrentMigrationTimestamp();
		
		// get latest number
		$num = MpmMigrationHelper::getCurrentMigrationNumber();
		
		// get list of migrations
		$list = MpmListHelper::getList();
		
		// get command line writer
		$clw = MpmCommandLineWriter::getInstance();
		$clw->writeHeader();
		
		if (empty($latest))
		{
			echo "You have not performed any migrations yet.";
		}
		else
		{
			echo "You are currently on migration $num -- " . $latest . '.';
		}
		
		echo "\n\nLooking for pending migrations...";
		
		// loop through, running the migrations that are after the current migration
		$total_migrations_needed = 0;
		$num = 0;
		foreach ($list as $obj)
		{
			if ($obj->timestamp > $latest)
			{
				echo "\n\t$num\t" . $obj->timestamp;
				$total_migrations_needed++;
			}
			$num++;
		}
		
		// if no migrations run, we're finished
		if ($total_migrations_needed == 0)
		{
			echo "\n\nYou are currently at the latest migration (none pending).\n";
		}
		else
		{
			echo "\n\n$total_migrations_needed migrations are pending.\nRun ./migrate.php latest to update your database.\n";
		}
		
		$clw->writeFooter();
	}
	
	/**
	 * Displays the help page for this controller.
	 * 
	 * @uses MpmCommandLineWriter::addText()
	 * @uses MpmCommandLineWriter::write()
	 * 
	 * @return void
	 */
	public function displayHelp()
	{
		$obj = MpmCommandLineWriter::getInstance();
		$obj->addText('./migrate.php status');
		$obj->addText(' ');
		$obj->addText('This command is used to display the current migration you are on and lists any pending migrations which would be performed if you migrated to the most recent version of the database.');
		$obj->addText(' ');
		$obj->addText('Valid Example:');
		$obj->addText('./migrate.php status', 4);
		$obj->write();
	}
	
}

?>