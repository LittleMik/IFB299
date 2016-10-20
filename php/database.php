<?php
	class Database{
		private $pdo;
		private $lastID;

		/**
		 * Constructor
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

		/**
		* Get Method
		* Returns variable corresponding to name
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

		/**
		*
		*
		*
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
		*
		*
		*
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



		function destroy_pdo()
		{
			//Destroy PDO Object
			$this->pdo = null;
		}
	}
?>
