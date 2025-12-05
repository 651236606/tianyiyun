<?php
/*##################################################
# 天翼网盘管理
# 模块功能：数据库操作类
###################################################*/
class M
{
	var $sql_id;
	var $sql_qc=0;
	
	function __construct($dbhost, $dbuser, $dbpw, $dbname = '', $charset = 'utf8',$newlink=false)
	{
		$this->sql_id = new mysqli($dbhost, $dbuser, $dbpw, $dbname, 3306);
		if(mysqli_connect_errno()) {
			$this->sql_id = false;
			exit("Mysqli 连接数据库失败,请确定数据库用户名,密码设置正确");
		}
		else{
			$this->sql_id->set_charset($charset);
		}
	}
	
	function close() {
		$this->sql_qc=0;
		return mysqli_close($this->sql_id);
	}
	
	function select_database($dbName)
	{
		return mysqli_select_db($dbName, $this->sql_id);
	}
	
	function fetch_array($query, $result_type = MYSQLI_ASSOC)
	{
		return mysqli_fetch_array($query, $result_type);
	}
	
	function real_escape_string($s){
		return mysqli_real_escape_string($this->sql_id,$s);
	}
	function query($sql)
	{
		$this->sql_qc++;
		return mysqli_query($this->sql_id,$sql);
	}
	
	function queryArray($sql,$keyf='')
	{
		$array = array();
		$result = $this->query($sql);
		while($r = $this->fetch_array($result))
		{
			if($keyf){
				$key = $r[$keyf];
				$array[$key] = $r;
			}
			else{
				$array[] = $r;
			}
		}
		return $array;
	}
	
	function affected_rows()
	{
		return mysqli_affected_rows($this->sql_id);
	}
	
	function num_rows($query)
	{
		return mysqli_num_rows($query);
	}
	
	function insert_id()
	{
		return mysqli_insert_id($this->sql_id);
	}
	
	function selectLimit($sql, $num, $start = 0)
	{
		if ($start == 0){
			$sql .= ' LIMIT ' . $num;
		}
		else{
			$sql .= ' LIMIT ' . $start . ', ' . $num;
		}
		return $this->query($sql);
	}
	
	function getOne($sql, $limited = false)
	{
		if ($limited == true){
			$sql = trim($sql . ' LIMIT 1');
		}
		$res = $this->query($sql);
		if ($res !== false){
			$row = mysqli_fetch_row($res);
			return $row[0];
		}
		else{
			return false;
		}
	}
	function getRow($sql)
	{
		$res = $this->query($sql);
		if ($res !== false){
			return mysqli_fetch_assoc($res);
		}
		else{
			return false;
		}
	}
	
	function getAll($sql)
	{
		$res = $this->query($sql);
		if ($res !== false){
			$arr = array();
			while ($row = mysqli_fetch_assoc($res)){
				$arr[] = $row;
			}
			return $arr;
		}
		else{
			return false;
		}
	}
	
	function getTableFields($dbName,$tabName)
	{
		$sql = "SELECT * FROM " . $tabName .' limit 1';
		$row = $this->query($sql);
		$res = mysqli_fetch_fields($row);
		$fields = array();
		foreach($res as $v)
		{
			$fields[] = $v->name;
		}
		return $fields;
	}
	
	function Exist($tabName,$fieldName ,$ID)
	{
		$SqlStr="SELECT * FROM ".$tabName." WHERE ".$fieldName."=".$ID;
		$res=false;
		try{
			$row = $this->getRow($SqlStr);
			if($row){ $res=true; }
			unset($row);
		}
		catch(Exception $e){
		}
		return $res;
	}
	
	function AutoID($tabName,$colname)
	{
		$n = $this->getOne("SELECT Max(".$colname.") FROM [".$tabName."]");
		if (!isNum(n)){ $n=0; }
		return $n;
	}
	
	function Add($tabName,$arrFieldName ,$arrValue)
	{
		$res=false;
		if (chkArray($arrFieldName,$arrValue)){
			$sqlcol = "";
			$sqlval = "";
			$rc=false;
			foreach($arrFieldName as $a){
				if($rc){ $sqlcol.=",";}
				$sqlcol .= $a;
				$rc=true;
			}
			$rc=false;
			foreach($arrValue as $b){
				if($rc){ $sqlval.=",";}
				$sqlval .= "'".  $b."'";
				$rc=true;
			}
			$sql = " INSERT INTO " . $tabName." (".$sqlcol.") VALUES(".$sqlval.")" ;
			//echo $sql."<br>";exit;
			$res = $this->query($sql);
			if($res){
				//echo "ok";
			}
			else{
				//echo "err";
			}
		}
		return $res;
	}
	
	function Update($tabName,$arrFieldName , $arrValue ,$KeyStr,$f=0)
	{
		$res=false;
		if (chkArray($arrFieldName,$arrValue)){
			$sqlval = "";
			$rc=false;
			
			for($i=0;$i<count($arrFieldName);$i++){
				if($rc){ $sqlval.=",";}
				if($f==0){
					$sqlval .= $arrFieldName[$i]."='".$arrValue[$i] ."'";
				}
				else{
					$sqlval .= $arrFieldName[$i]."='". $arrValue[$arrFieldName[$i]] ."'";
				}
				$rc=true;
			}
			$sql = " UPDATE " . $tabName." SET ".$sqlval." WHERE ".$KeyStr."";
			//echo $sql."<br>";
			$res = $this->query($sql);
			if($res){
				//echo "ok";
			}
			else{
				//echo "err";
			}
		}
		return $res;
	}
	
	function Delete($tabName,$KeyStr)
	{
		$res=false;
		$sql = "DELETE FROM ".$tabName." WHERE ".$KeyStr;
		$res = $this->query($sql);
		return $res;
	}
}
?>