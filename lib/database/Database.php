<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	require_once $_SERVER['framework'] . '/core/Core.php';

	/**
	* This class will access the database
	* connects to the database and make 
	* shot-hand functions to easily make database
	* queries and easily retrieve data
	*/

	class Database extends MagicMethods{

		private $_driver;
		private $_host;
		private $_dbName;
		private $_username;
		private $_password;
		private $_dbConnection;
		private $_lastInsertId;

		private static $_instance = null;

		public function __construct($db){
			$this->_driver = $db['db_driver'];
			$this->_host = $db['db_host'];
			$this->_dbName = $db['db_name'];
			$this->_username = $db['db_username'];
			$this->_password = $db['db_password'];

		}


		public static function getInstance($db){
			if(self::$_instance == null) {
				$className = __CLASS__;
				self::$_instance = new $className($db);				
			}

			return self::$_instance;
		}


		/**
		* @return PDO return
		* @throws PDOException
		*/
		public function connect () {
			try {
				$_uri = $this->_driver . ':host=' . $this->_host . ';dbname=' . $this->_dbName;
				
				$this->_dbConnection = new PDO($_uri,$this->_username,$this->_password);
				$this->_dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				throw new PDOException('Error: Cannot connect to database. Message: ' . $e->getMessage());
			}
		}

		/**
		* @param PDO dbConnection object to use
		* @param string tableName Name of the table to get data from
		* @param string whereClause Conditions of the query
		* @param string orderByClause Name of the field and type of sorting (ASC,DESC)
		* @return Array all data results
		*/
		public function selectAll($tableName, $whereClause = '', $orderByClause = ''){
			try {
				$query = "	SELECT *
							FROM {$tableName} ";

				//check if there is a where clause
				if(!empty($whereClause)) {
					$query .= "WHERE {$whereClause}";
				}

				//check if there is an order clause
				if(!empty($orderByClause)) {
					$query .= "ORDER BY {$orderByClause}";
				}

				$statement = $this->_dbConnection->prepare($query);
				$statement->execute();

				return $statement->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				throw new PDOException('Error: Unable to select data: Message: ' . $e->getMessage());
			}
		}

		public function query($query,$bindParams = array()){
			try {


				$statement = $this->_dbConnection->prepare($query);

				foreach ($bindParams as $value) {
					$statement->bindParam($value['bind_param'],$value['value'],$value['type']);
				}
				$statement->execute();
				

				return $statement->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				throw new PDOException('Error: Unable to select data: Message: ' . $e->getMessage());
			}
		}


		public function insert($tableName,$data,$bindParams = array()){
			try {
				$query = '
					INSERT ' . $tableName . '
					SET 
				';

				foreach ($data as $field => $value) {
					$query .= ' ' . $field . ' = ' . $value . ',';
				}

				$query = preg_replace('/(,)$/', '', $query);
				$statement = $this->_dbConnection->prepare($query);

				foreach ($bindParams as $value) {
					$statement->bindParam($value['bind_param'],$value['value'],$value['type']);
				}

				$executeResult = $statement->execute();
				$this->_lastInsertId = $this->_dbConnection->lastInsertId();	

				

				return $executeResult;
			} catch(PDOException $e) { 
				throw new PDOException('Error: Unable to insert data: Message: ' . $e->getMessage());
			}
		}

		public function update($tableName,$data,$whereClause,$bindParams = array()){
			try {
				$query = '
					UPDATE ' . $tableName . '
					SET 
				';

				foreach ($data as $field => $value) {
					$query .= ' ' . $field . ' = ' . $value . ',';
				}

				$query = preg_replace('/(,)$/', '', $query);


				if(!empty($whereClause)) {
					$query .= ' WHERE ' . $whereClause;
				}
				
				$statement = $this->_dbConnection->prepare($query);

				foreach ($bindParams as $value) {
					$statement->bindParam($value['bind_param'],$value['value'],$value['type']);
				}

				$executeResult = $statement->execute();

				

				return $executeResult;
			} catch(PDOException $e) { 
				throw new PDOException('Error: Unable to update data: Message: ' . $e->getMessage());
			}
		}

		public function setDriver($driver) {
			$this->_driver = $driver;
		}

		public function setHost($host) {
			$this->_host = $host;
		}

		public function setDbName($dbName) {
			$this->_dbName = $dbName;
		}

		public function setUsername($username) {
			$this->_username = $username;
		}

		public function setPassword($password) {
			$this->_password = $password;
		}

		public function setDbConnection ($dbConnection) {
			$this->_dbConnection = $dbConnection;
		}

		public function getDbConnection(){
			return $this->_dbConnection;
		}

		public function setLastInsertId($lastInsertId) {
			$this->_lastInsertId = $lastInsertId;
		}

		public function getLastInsertId() {
			return $this->_lastInsertId;
		}
		public function sampleQuery(){
			$query = '
				SELECT 		*
				FROM 		admin_user
				INNER JOIN 	user
						ON 	user.id = admin_user.user_id
				WHERE 		admin_user.username= "admin"
				AND			admin_user.password= "admin"
			';

			$statement = $this->_dbConnection->prepare($query);
			$statement->execute();

			print_r($statement->fetchAll(PDO::FETCH_ASSOC));
		}
	}
?>