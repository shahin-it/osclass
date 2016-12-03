<?php

/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 22-Jul-16
 * Time: 1:26 AM
 */
class DbUtil extends DAO
{
    private static $instance;

    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function getConnection($dbHost = null, $dbUser = null, $dbPassword = null, $dbName = null, $tablePrefix = null)
    {
        if ($dbHost == null) {
            $dbHost = osc_db_host();
        }
        if ($dbUser == null) {
            $dbUser = osc_db_user();
        }
        if ($dbPassword == null) {
            $dbPassword = osc_db_password();
        }
        if ($dbName == null) {
            $dbName = osc_db_name();
        }
        return new DBConnectionClass($dbHost, $dbUser, $dbPassword, $dbName);
    }

    public function import($path)
    {
        $sql = file_get_contents($path);
        if (!$this->dao->importSQL($sql)) {
            throw new Exception($this->dao->getErrorLevel() . ' - ' . $this->dao->getErrorDesc());
        }
        return true;
    }

    public function makeDao($table, $pk, $fields = null)
    {
        $this->clearDao();
        $this->setTableName($table);
        $this->setPrimaryKey($pk);
        if ($fields != null) {
            $this->setFields($fields);
        }
        return $this;
    }

    public function clearDao() {
        $this->setTableName(null);
        $this->setPrimaryKey(null);
        $this->setFields(array());
        return $this;
    }

    public function countAll($conditionMap = array())
    {
        $this->dao->select();
        $this->dao->from($this->getTableName());
        foreach ($conditionMap as $field => $value) {
            $this->dao->where($field, $value);
        }
        $result = $this->dao->get();
        if ($result) {
            $items = $result->result();

            if (count($items) == 0) {
                return array();
            }
            return $items;
        } else {
            return array();
        }
    }

    public function listAll($conditionMap = array(), $configMap = array())
    {
        if(!is_array($conditionMap)) {
            return $this->dao->query("SELECT * FROM ".$this->getTableName()." ".$conditionMap)->result();
        }
        $config = array_merge(array(
            "offset" => 0,
            "max" => null,
            "orderBy" => $this->getPrimaryKey(),
            "order" => "desc"
        ), $configMap);
        $this->dao->select();
        $this->dao->from($this->getTableName());
        foreach ($conditionMap as $field => $value) {
            $this->dao->where($field, $value);
        }
        if (!is_null($config['orderBy'])) {
            $this->dao->orderBy($config['orderBy'], $config['order']);
        }
        $this->dao->limit($config['max'], $config['offset']);
        $result = $this->dao->get();
        if ($result) {
            $items = $result->result();

            if (count($items) == 0) {
                return array();
            }
            return $items;
        } else {
            return array();
        }
    }

    public function findLastId() {
        return $this->dao->insertedId();
    }

    public function date($format = 'Y-m-d h:i:s') {
        return date($format);
    }

}