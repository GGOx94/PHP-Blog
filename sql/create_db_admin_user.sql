--
-- FIX pour crash MySQL (mysqldb.db corrupt & can't repair)
-- open shell : mysqld –-console –-skip-grant-tables –-skip-external-locking
-- open other shell : mysqlcheck -r --databases mysql --use-frm
-- stop MySql, close shells and restart normally
--
# Création et privilèges pour `ggo_db`@`localhost` sur la base p5phpblog

CREATE USER IF NOT EXISTS 'ggo_db'@'localhost' IDENTIFIED BY '123_db';

GRANT ALL PRIVILEGES ON `p5phpblog`.* TO 'ggo_db'@'localhost' IDENTIFIED BY '123_db';
