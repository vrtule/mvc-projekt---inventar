<?php
class Db
{
    private static $connection;
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function connect($host, $user, $password, $database) {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO("mysql:host=$host;dbname=$database", $user, $password, self::$options);
        }
    }

    public static function queryForOne($query, $parameters = array()) {
        $results = self::$connection->prepare($query);
        $results->execute($parameters);
        return $results->fetch();
    }

    public static function queryForAll($query, $parameters = array()) {
        $results = self::$connection->prepare($query);
        $results->execute($parameters);
        return $results->fetchAll();
    }

    public static function query($query, $parameters = array()) {
        $results = self::$connection->prepare($query);
        $results->execute($parameters);
        return $results->rowCount();
    }
	
	public static function insert($table, $parameters = array()) {
		return self::query("INSERT INTO `$table` (`".
		implode('`, `', array_keys($parameters)).
		"`) VALUES (".str_repeat('?,', sizeOf($parameters)-1)."?)",
			array_values($parameters));
	}
	
	public static function update($table, $values = array(), $conditions, $parameters = array()) {
		return self::query("UPDATE `$table` SET `".
		implode('` = ?, `', array_keys($values)).
		"` = ? " . $conditions,
		array_merge(array_values($values), $parameters));
	}

    public static function returnCount() {
        $query = "SELECT COUNT(*) AS num FROM `zbozi`";
        $results = self::$connection->prepare($query);
        $results->execute();
        return $results->fetch(PDO::FETCH_ASSOC);
    }


	
}