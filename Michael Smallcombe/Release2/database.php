<?php
	// ======================================== Database Class ======================================== //
	/**
	*	Database Class
	*
	*	Contains a PDO object for the execution of SQL queries and
	* a value to save the lastID when executing update or insert queries
	*
	*	@author Michael Smallcombe
	*/
	// ============================================================================================= //
	class Database
	{

		private $pdo;
		private $lastID;

		// ==================== Constructor ==================== //
		/**
		* Constructor
		*
		*/
		function __construct()
		{
			//Setup New PDO
			$this->pdo = new PDO(
				'mysql:host=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_de4e6e6a36fcb39',
				'b82dd638ef1f83',
				'07d1dd63'
			);
			//Set PDO Attribute
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		// ==================== Getters ==================== //
		/**
		* Override of Get Method
		* Returns variable corresponding to name
		*
		* @param (String) $var Variable name
		*
		* @return (mixed) variable corresponding to the input name or null
		*/
		function __get($var)
		{
			switch($var)
			{
				case 'pdo':
					return $this->pdo;
					break;
				case 'lastID':
					return $this->lastID;
					break;
				default:
					return null;
					break;
			}
		}

		// ==================== Database Query Functions ==================== //
		/**
		* Select Statement
		* Uses PDO to bind input values with an input query
		* Returns a result statment
		*
		* @param (String) $query SQL Query for database
		* @param (array) $parameters Containing values to bind against query inputs
		*
		* @return (PDOStatement) result statement from the select query
		*/
		function select_statement($query, $parameters)
		{
			try{
				//Prepare Query
				$stmt = $this->pdo->prepare($query);

				//Apply Values to Parameters in Query
				foreach($parameters as $parameter => $value)
				{
					$stmt->bindValue($parameter, $value);
				}

				//Run Query
				$stmt->execute();

				//Return PDO Statmenet
				return $stmt;

			} catch (PDOException $e){
				//Output Error
				echo $e->getMessage();
				echo '<p>'.$e.'</p>';
			}
		}

		/**
		* Update Statement
		* Uses PDO to bind input values with an input query
		* Does not return a result statement and saves the lastInsertId of the query
		*
		* @param (String) $query SQL Query for database
		* @param (array) $parameters Containing values to bind against query inputs
		*/
		function update_statement($query, $parameters)
		{
			try{

				//Prepare Query
				$stmt = $this->pdo->prepare($query);

				//Apply Values to Parameters in Query
				foreach($parameters as $parameter => $value)
				{
					$stmt->bindValue($parameter, $value);
				}

				//Run Query
				$stmt->execute();

				//Get ID of updated row
				$this->lastID = $this->pdo->lastInsertId();

				//Close connection
				$stmt = null;

			} catch (PDOException $e){
				//Output Error
				echo $e->getMessage();
				echo '<p>'.$e.'</p>';
			}
		}

		// ==================== Helpers ==================== //
		/**
		* Destroy PDO
		* Destroys the PDO Object to thoroughly terminate the connection with the database
		*
		*/
		function destroy_pdo()
		{
			//Destroy PDO Object
			$this->pdo = null;
		}
	}
?>
