<?php

require_once __DIR__ . '/config.php';

use App\Database\DB;

$db = DB::getInstance();
$db->createDatabase();

$db->createTable(
    'users',
    '
     id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(255) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL,
     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
',
);

$db->createTable(
    'sessions',
    '
     id VARCHAR(128) PRIMARY KEY,
     data BLOB NOT NULL,
     iv BLOB NOT NULL,
     tag BLOB NOT NULL,
     last_activity INT NOT NULL,    
     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
',
);

$db->createTable(
    'lobbies',
    '
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255),
    host_user_id INT NOT NULL,
    start_money INT NOT NULL,
    status BOOLEAN NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (host_user_id) REFERENCES users(id) ON DELETE CASCADE
',
);

$db->createTable(
    'lobby_users',
    '
    id INT AUTO_INCREMENT PRIMARY KEY,
    lobby_id INT NOT NULL,
    user_id INT NOT NULL,
    is_ready BOOLEAN DEFAULT 0,
    money INT DEFAULT 1500,
    position INT DEFAULT 0,
    properties TEXT, -- store property IDs as JSON or CSV
    is_bankrupt BOOLEAN DEFAULT 0,
    in_jail BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lobby_id) REFERENCES lobbies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (lobby_id, user_id)
',
);
$str = implode(', ', $db->getTablesName());
echo "Database: '{$db->getDbName()}' and tables '$str' created successfully." . PHP_EOL;
exit();
