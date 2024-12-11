<?php 
class Database {
	public $hConn;
	
	public function startdb() {
		global $lang;
		$this->hConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

		if(!$this->hConn || !mysqli_select_db($this->hConn, DB_NAME)) {
			throw new Exception($lang['class.Database.php.con']. " " . E_USER_ERROR);
		}

        return $this;
	}

	public function select_array($table, $arFields, $arConditions) {
 		// tworzy tablice dla klauzuli WHERE 
		$arWhere = array();
		foreach($arConditions as $field => $val) {
			if(! is_numeric($val)) {
			// cytuje dane 
			$val = "'" . mysqli_real_escape_string($this->hConn, $val) . "'";
			}
			$arWhere[] = "$field = $val";
		}
		$sql = "SELECT $arFields";
		$sql .= " FROM $table";
		$sql .= ' WHERE ' . join(' AND ', $arWhere);
	
		echo $sql;

		$hRes = @mysqli_query($this->hConn, $sql);
		if(!$hRes) {
			$err = mysqli_error($this->hConn);
			throw new Exception($err); 
		} 
 
		$arReturn = array(); 
		while( ($row = mysqli_fetch_assoc($hRes)) ) {
			$arReturn[] = $row; 
		}
		return $arReturn; 
	}

	public function select($sql) { 	
		$hRes = @mysqli_query($this->hConn, $sql);
		if(!$hRes) {
			$err = mysqli_error($this->hConn);
			throw new Exception($err); 
			//echo $err;
		}
 
		$arReturn = array(); 
		while( ($row = mysqli_fetch_assoc($hRes)) ) {
			$arReturn[] = $row; 
		}
		return $arReturn; 
	}
	
	public function select_r($sql) {
		$dane = $this->select($sql);
		return $dane[0];
	}
	
	
	public function insert($table, $arFieldValues) {
		$fields = array_keys($arFieldValues); 
		$values = array_values($arFieldValues); 
		// Tworzy tablice wartoci, ktora zostanie
		// doczona do klauzuli VALUES 
		// Funkcja pg_escape_string cytuje 
		// te wartoci, ktore nie sa liczbowe. 
		
		$escVals = array(); 
		foreach($values as $val) {
			if((! is_numeric($val)) AND ($val <> 'True') AND ($val <> 'False')) { // cytuje dane 
				$val = "'" . mysqli_real_escape_string($this->hConn, $val) . "'";
			} 
			$escVals[] = $val; 
		}
		 
		// tworzy instrukcjďż˝SQL 
		$sql = " INSERT INTO $table ("; 
		$sql .= join(', ', $fields); 
		$sql .= ') VALUES('; 
		$sql .= join(', ', $escVals); 
		$sql .= ')'; 
		
		$hRes = mysqli_query($this->hConn, $sql);
		if(!$hRes) {
			$err = mysqli_error($this->hConn) . "\n" . $sql;
			throw new Exception($err);
		}
		
		return mysqli_affected_rows($this->hConn);
	}

	public function update($table, $arFieldValues, $arConditions) {
	// tworzy tablice dla klauzuli SET 
		$arUpdates = array();
		foreach($arFieldValues as $field => $val) {
			if((! is_numeric($val)) AND ($val <> 'True') AND ($val <> 'False')) { // cytuje dane 
				$val="'" . mysqli_real_escape_string($this->hConn, $val) . "'";
			}
			$arUpdates[] = "$field = $val";
		}
		// tworzy tablice dla klauzuli WHERE 
		$arWhere = array();
		foreach($arConditions as $field => $val) {
			if(! is_numeric($val)) {
			// cytuje dane 
			$val = "'" . mysqli_real_escape_string($this->hConn, $val) . "'";
			}
			$arWhere[] = "$field = $val";
		}

		$sql = "UPDATE $table SET ";
		$sql .= join(', ', $arUpdates);
		$sql .= ' WHERE ' . join(' AND ', $arWhere);
		//echo $sql;
		$hRes = mysqli_query($this->hConn, $sql);
		if(!$hRes) {
			$err = mysqli_error($this->hConn) . NL . $sql;
			throw new Exception($err); 
      		}
		return mysqli_affected_rows($this->hConn);
	}
	
	public function query_pg($sql) {
		//echo $sql;
		$hRes = mysqli_query($sql);
		if(! is_resource($hRes)) {
			$err = mysqli_error() . NL . $sql;
			throw new Exception($err); 
      		}
		return mysqli_affected_rows($hRes);
	}
	
	public function query($sql, $debug=false) {
		//echo $sql;
		$hRes = mysqli_query($this->hConn, $sql);
		if($debug) {
			if(!$hRes) {
				$err = mysqli_error($this->hConn) . '<br>' .  $sql;
				throw new Exception($err);
			}
		}
		return($hRes);
	}
	
	public function insertId() {
        return(mysqli_insert_id($this->hConn));
	}
	
	function delete($table, $arConditions) {
		// tworzy tablice dla klauzuli WHERE 
		$arWhere = array(); 
		foreach($arConditions as $field => $val) { 
			if(! is_numeric($val)) { 
				// cytuje dane 
				$val = "'" . mysqli_real_escape_string($this->hConn, $val) . "'";
			}
			$arWhere[] = "$field = $val";
		} 
		
		//var_dump($arWhere);
		//echo "<BR>";
		
		$sql = "DELETE FROM $table WHERE " . join(' AND ', $arWhere);
		$hRes = mysqli_query($this->hConn, $sql);
		if(! is_resource($hRes)) {
			$err = mysqli_error($this->hConn) . NL . $sql;
			throw new Exception($err);
		}
		return mysqli_affected_rows($this->hConn);
	}

    public function Escape($string) {
        return mysqli_real_escape_string($this->hConn, $string);
    }


}