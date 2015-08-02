# Adding a New Migration #

Type: `php migrate.php add`

A new migration file will be created and the filename will be provided.  Example:

```
       __ __         __      __                                                 
|\/|  (_ /  \|   __ |__)|__||__) __ |\/|. _  _ _ |_. _  _  _                    
|  |\/__)\_\/|__    |   |  ||       |  ||(_)| (_||_|(_)| )_)                    
    /                                    _/                                     
********************************************************************************
                                                                                
New migration created: file /db/2008_11_12_19_50_08.php                         
                                                                                
********************************************************************************
```

Load this migration script in your favorite IDE or text editor.  You will find two methods, up() and down().  Example:

```
<?php

class Migration_2008_11_12_19_50_08 extends MpmMigration
{

	public function up(PDO &$pdo)
	{
		
	}

	public function down(PDO &$pdo)
	{
		
	}

}

?>
```

In the up() method, add the database changes you wish to make for this migration.  In the down() method, you should add the changes which would be used to fully reverse the changes you added to the up() method.  Example:

```
<?php

class Migration_2008_11_12_19_50_08 extends MpmMigration
{

	public function up(PDO &$pdo)
	{
		$pdo->exec("ALTER TABLE `test0` ADD `field1` VARCHAR(24) NOT NULL");
	}

	public function down(PDO &$pdo)
	{
		$pdo->exec("ALTER TABLE `test0` DROP `field1`");
	}

}

?>
```

Once you've added your migration, be sure to update your own database using the latest command: `php migrate.php latest`

It's usually good practice to commit migrations to your project SVN repository as soon as you've added it so that other developers can migrate to the latest database schema.

You can get a complete list of commands as well as built-in help by using the help command: `php migrate.php help`.