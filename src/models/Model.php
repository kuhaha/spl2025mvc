<?php
namespace spl2025\models; 

/**
 * モデル（Model）のベースとなるクラス
 */

abstract class Model
{
    protected $table;
    protected $db;
    protected static $conf = [
        'host'=>'localhost', 'user'=>'root','pass'=>'root','dbname'=>'test'
    ];
    
    function __construct($conf = null){
        self::$conf = $conf?? self::$conf;
        $conn =  new \mysqli(
            self::$conf['host'],
            self::$conf['user'],
            self::$conf['pass'],
            self::$conf['dbname']
        );
        if ($conn->connect_errno) {
            die($conn->connect_error);
        }
        $conn->set_charset('utf8');
        $this->db = $conn;
    }
    
    public static function setDbConf($conf){
        self::$conf = $conf;
    } 
    
    public function query($sql, $orderby=null, $limit=0, $offset=0){
        $sql .= $orderby ? " ORDER BY {$orderby}" : '';
        $sql .= $limit > 0 ? " LIMIT {$limit} OFFSET {$offset}" : '';
        $rs = $this->db->query($sql);
        if (!$rs) die ('DBエラー: ' . $sql . '<br>' . $this->db->error);
        return $rs->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql){
        $rs = $this->db->query($sql);
        if (!$rs) die ('DBエラー: ' . $sql . '<br>' . $this->db->error);
    } 
        
   public  function getList($where=1, $orderby=null, $limit=0, $offset=0){
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        return $this->query($sql,$orderby, $limit, $offset);
    }

    public function getDetail($where){
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $data = $this->query($sql);
        return $data[0]??[];
    }
    
    /**
     * insert(): insert an array of data as a row of the table
     * @params: $data, array [$column_name => $column_value]
     *    e.g.,  ['name'=>'foo', 'age'=>18, 'tel'=>'090-1234-5678'] 
     * @return, number of rows affected 
     */
    public function insert($data){
        $keys = implode(',', array_keys($data));
        $values = array_map(fn($v)=>is_string($v) ? "'{$v}'" : $v, array_values($data));
        $values = implode(",", $values);
        $sql = "INSERT INTO {$this->table} ($keys) VALUES ($values)";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
    
    /**
     * update(): update the table using the given data
     * @params: $data, array [$column_name => $column_value]
     *    e.g.,  ['name'=>'foo', 'age'=>18, 'tel'=>'090-1234-5678']
     *  $where, string, condition to be used in WHERE clause 
     * @return, number of rows affected  
     */
    public function update($data, $where){
        $keys = array_keys($data);
        $values = array_map(fn($v)=>is_string($v) ? "'{$v}'" : $v, array_values($data));
        $values = array_map(fn($k, $v)=>"{$k}={$v}", array_combine($keys, $values));
        $sql = "UPDATE {$this->table} SET {$values} WHERE {$where}";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
    
    /**
     * delete(): delete row(s) from the table using the given condition
     * @params: $where, string, condition to be used in WHERE clause
     * @return, number of rows affected 
     */
    public function delete($where){
        $sql = "DELETE FROM {$this->table} WHERE {$where}";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
}