  1. Download and unpack archive to the location where you want to handle your migrations; this project is designed and intended to be incorporated with other projects and reside within their SVN repositories.
  1. CHMOD migrate.php to be executable.
  1. Open migrate.php and modify the top line so it points to the path/file of your PHP binary.
  1. Make sure you have a valid username/password for your MySQL database server and have already created the database on which you will be performing migrations against.
  1. On the command line, run the following and answer the prompts: ./migrate.php init