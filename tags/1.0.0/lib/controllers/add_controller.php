<?php
/**
 * This file houses the MpmAddController class.
 *
 * @package    mysql_php_migrations
 * @subpackage Controllers
 * @license    http://www.opensource.org/licenses/bsd-license.php  The New BSD License
 * @link       http://code.google.com/p/mysql-php-migrations/
 */

/**
 * The MpmUpController is used to migrate up to a new version.
 *
 * @package    mysql_php_migrations
 * @subpackage Controllers
 */
class MpmAddController extends MpmController
{
	
	/**
	 * Determines what action should be performed and takes that action.
	 *
	 * @uses MpmUpController::displayHelp()
	 * 
	 * @return void
	 */
	public function doAction()
	{
		// make sure system is init'ed
		$this->checkIfReady();
		
		// get date stamp for use in generating filename
		$date_stamp = gmdate('Y_m_d_H_i_s');
		$filename = $date_stamp . '.php';
		$classname = 'Migration_' . $date_stamp;
		
		// get list of files
		$files = MpmListHelper::getFiles();
		
		// if filename is taken, throw error
		if (in_array($filename, $files))
		{
			$obj = MpmCommandLineWriter::getInstance();
			$obj->addText('Unable to obtain a unique filename for your migration.  Please try again in a few seconds.');
			$obj->write();
		}
		
		// create file
		$file = "<?php\n\n";
		$file .= 'class ' . $classname . ' extends MpmMigration' . "\n";
		$file .= "{\n\n";
		$file .= "\t" . 'public function up(PDO &$pdo)' . "\n";
		$file .= "\t{\n\t\t\n";
		$file .= "\t}\n\n";
		$file .= "\t" . 'public function down(PDO &$pdo)' . "\n";
		$file .= "\t{\n\t\t\n";
		$file .= "\t}\n\n";
		$file .= "}\n\n";
		$file .= "?>";
		
		$fp = fopen(MPM_PATH . '/db/' . $filename, "w");
		if ($fp == false)
		{
			$obj = MpmCommandLineWriter::getInstance();
			$obj->addText('Unable to write new migration file.');
			$obj->write();
		}
		$success = fwrite($fp, $file);
		if ($success == false)
		{
			$obj = MpmCommandLineWriter::getInstance();
			$obj->addText('Unable to write new migration file.');
			$obj->write();
		}
		fclose($fp);
		
		$obj = MpmCommandLineWriter::getInstance();
		$obj->addText('New migration created: file /db/' . $filename);
		$obj->write();
		
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
		$obj->addText('./migrate.php add [description]');
		$obj->addText(' ');
		$obj->addText('This command is used to create a new migration script.  The script will be created and prepopulated with the up() and down() methods which you can then modify for the migration.');
		$obj->addText(' ');
		$obj->addText('The description must be less than 40 characters and words should be separated by underscores.  It should be a very short explanation of what the migration does.');
		$obj->addText(' ');
		$obj->addText('Valid Examples:');
		$obj->addText('./migrate.php add create_users_table', 4);
		$obj->addText('./migrate.php add alter_accounts_table', 4);
		$obj->addText('./migrate.php add setup_initial_project_schema', 4);
		$obj->write();
	}
	
}

?>