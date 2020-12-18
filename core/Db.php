

<?php


class DB
{
    public static $db;
    public static $tableName;
    public static $insertData;
    public static $whereColumn;
    public static $whereColumnValue;
    public static $queue;
    public static $selectList;
    public static $andColumn;
    public static $andColumnValue;
	public static $andSelectList;
	
	public static $DB_NAME         = 'test';
    public static $USER            = 'root';
    public static $PASSWORD        = '';

	public static function Connect()
    {
        try
        {
			$db = new PDO("mysql:host=localhost;dbname=" . self::$DB_NAME . ";charset=utf8,". self::$USER.",".self::$PASSWORD);
            $db->query("SET NAMES utf8");
            return $db;            
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public static function table($tableName)
    {
    	self::$tableName = $tableName;

    	return new self();
    }

	public static function select()
	{
		self::$db = self::Connect();
		
		$select = self::$db->prepare("SELECT * FROM " . self::$tableName);
		$select->execute();
		
		while($get = $select->fetch(PDO::FETCH_ASSOC))
		{
			self::$selectList[] = $get;
		}

		return new self();
	}

	public static function insert($insertData)
	{
		$arrayKeys = array_keys($insertData);

		$columnList = implode(',',$arrayKeys);

		for($i = 0; $i < count($insertData); $i++)
		{
			self::$queue[] = '?';
		}

		$queueList = implode(',', self::$queue);

		self::$db = self::Connect();

		$insertQuery = "INSERT INTO ". self::$tableName. " ($columnList) VALUES ($queueList)";
		$insert = self::$db->prepare($insertQuery);
		$insert->execute(
			array_values($insertData)
		);
	}

	public static function where($column, $columnValue)
	{
		self::$db = self::Connect();

		self::$whereColumn = $column;
		self::$whereColumnValue = $columnValue;

		$selectWhereQuery = "SELECT * FROM " . self::$tableName ." WHERE ". $column . "=". "'$columnValue'";

		$selectWhere = self::$db->prepare($selectWhereQuery);
		$selectWhere->execute();

		self::$selectList = [];

		while($getWhere = $selectWhere->fetch(PDO::FETCH_ASSOC))
		{
			self::$selectList[] = $getWhere;
		}

		return new self();
	}

	public static function and2($column, $columnValue)
	{
		self::$db = self::Connect();

		$wCol = self::$whereColumnValue;

		$andQuery = "SELECT * FROM " . self::$tableName . " WHERE " . 
							self::$whereColumn . "=" ."'$wCol'" . " AND ". $column . "=" . "'$columnValue'";

		$andSelect = self::$db->prepare($andQuery);
		$andSelect->execute();

		if($andSelect->fetchColumn() > 0)
		{
			while($getAndWhere = $andSelect->fetch(PDO::FETCH_ASSOC))
			{
				self::$andSelectList[] = $getAndWhere;
			}

			return new self();
		}
		else
		{
			return 0;
		}
	}

	public static function update($updateData)
	{
		self::$db = self::Connect();

		$updateKeys = array_keys($updateData);

		$keysQueue = implode('=?,',$updateKeys);
		$keysQueue .= '=?';

		$updateWhereColumn = self::$whereColumnValue;

		$updateQuery = "UPDATE " . self::$tableName . " SET " . $keysQueue . " WHERE " . self::$whereColumn . '= '. "'$updateWhereColumn'";

		$update = self::$db->prepare($updateQuery);
		$update->execute(
			array_values($updateData)
		);

	}

	public static function delete($column, $value)
	{
		$deleteQuery = "DELETE FROM " . self::$tableName . " WHERE " . $column ." = ". "'$value'";

		$delete = self::$db->prepare($deleteQuery);
		$delete->execute();

		if($delete)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function get()
	{
		if(self::$andSelectList != NULL)
		{
			return @self::$andSelectList;
		}
		else
		{
			return @self::$selectList;
		}
	}


}