<?php

  /*
  |--------------------------------------------------------------------------
  | sql::operate MySQL or MariaDB
  |--------------------------------------------------------------------------
  |
  | Do a select query:
  |
  | sql::select('table_name')->where('a=? and b=?',[$a,$b])->limit([2,5])->order('a_column')->by('desc')->fetch();
  |
  | //generates query 'SELECT * FROM table_name WHERE a=? AND b=? LIMIT 2,5 ORDER a_column BY desc' and fetch result
  | //limit can be an int
  |
  | returns: array (single layer if limit is set to 1)
  |
  |--------------------------------------------------------------------------
  |
  | Do an insert query:
  |
  | sql::insert('table_name')->this([
  |   $array_1,
  |   $array_2,
  |   $array_3
  | ]); //insert 3 arrays as seperate lines
  |
  | returns: NULL
  |
  |--------------------------------------------------------------------------
  |
  | Do an update query:
  |
  | sql::update('table_name')->this([
  |   'column_1'=>'value_1',
  |   'column_2'=>'value_2',
  |   'column_3'=>'value_3'
  | ])->where('a=? and b=?',[$a,$b])->limit(3)->execute();
  |
  | returns: NULL
  |
  |--------------------------------------------------------------------------
  |
  | Do a delete query:
  |
  | sql::delete('table_name')->where('a=? and b=?',[$a,$b])->limit(3)->execute();
  |
  | returns: NULL
  |
  |
  |
  */

namespace angel;

class sql
{
    public static $config;

    public static $connect;

    private static $query;

    private static $value = [];

    private static $type;

    public static function config($i)
    {
        self::$config = $i;
    }

    private static function connect()
    {
        self::$connect = new \mysqli(self::$config['address'], self::$config['username'], self::$config['password'], self::$config['database']);
        if (self::$connect->connect_error) {
            system::add_error('sql::config()', 'connect_fail', 'fail to connect to your MySQL database');
        }
    }

    public static function run($query)
    {
        if (empty(self::$connect)) {
            self::connect();
        }
        if (!self::$connect->query($query)) {
            system::add_error('sql::run()', 'query_fail', 'fail to run query');
        }
    }

    public static function select($table)
    {
        self::$value = [];
        self::$query = null;
        if (empty(self::$connect)) {
            self::connect();
        }
        self::$query = 'select * from '.$table;
        return new sql();
    }

    public static function insert($table)
    {
        self::$query = null;
        self::$type = null;
        if (empty(self::$connect)) {
            self::connect();
        }
        self::$query = 'insert into '.$table.' values ';
        self::$type = 'insert';
        return new sql();
    }

    public static function delete($table)
    {
        self::$query = null;
        if (empty(self::$connect)) {
            self::connect();
        }
        self::$query = 'delete from '.$table;
        return new sql();
    }

    public static function update($table)
    {
        self::$query = null;
        self::$type = null;
        if (empty(self::$connect)) {
            self::connect();
        }
        self::$query = 'update '.$table.' set ';
        self::$type = 'update';
        return new sql();
    }

    public function this($bind, $add_on='none')
    {
        switch (self::$type) {
        case 'insert':
          $query = self::$query;
          $value = [];
          if (gettype($bind[0])==='array') {
              $query .= rtrim(str_repeat('('.rtrim(str_repeat('?,', count($bind[0])), ',').'),', count($bind)), ',');
              foreach ($bind as $i) {
                  foreach ($i as $single_i) {
                      array_push($value, $single_i);
                  }
              }
          } else {
              $query .= '('.rtrim(str_repeat('?,', count($bind)), ',').')';
              foreach ($bind as $i) {
                  array_push($value, $i);
              }
          }
          self::$value = $value;
          self::$query = $query;
          self::execute();
          break;
        case 'update':
          $query = self::$query;
          $value = [];
          if (is::str($bind)) {
              if (is::ary($add_on)) {
                  foreach ($add_on as $key=>$i) {
                      array_push($value, $i);
                  }
              }
              $query = $bind;
          } else {
              foreach ($bind as $key=>$i) {
                  $query .= $key.'=?,';
                  array_push($value, $i);
              }
              $query = rtrim($query, ',');
              //if simple equal
          }
          self::$value = $value;
          self::$query = $query;
          return new sql();
          break;
      }
    }

    public function where($filter, $bind=[])
    {
        self::$query .= ' where '.$filter;
        if (self::$type==='update') {
            foreach ($bind as $i) {
                array_push(self::$value, $i);
            }
        } else {
            self::$value = $bind;
        }
        return new sql();
    }

    public function limit($range)
    {
        if (is_array($range)) {
            self::$query .= ' limit '.$range[0].','.$range[1];
        } else {
            self::$query .= ' limit '.$range;
        }
        return new sql();
    }

    public function execute()
    {
        if ($stmt = self::$connect->prepare(self::$query)) {
            $value = self::$value;
            $in_p = [''];
            foreach ($value as $v) {
                $in_p[0] .= is::int($v)?'i':'s';
                array_push($in_p, $v);
            }
            $stmt->bind_param(...$in_p);
            $stmt->execute();
            $stmt->close();
        } else {
            system::add_error('sql::execute()', 'query_fail', '"'.self::$query.'" query failed');
        }
    }

    public function order($para)
    {
        self::$query .= ' order by '.$para;
        return new sql();
    }

    public function by($order)
    {
        self::$query .= ' '.$order;
        return new sql();
    }

    public function fetch()
    {
        if ($stmt = self::$connect->prepare(self::$query)) {
            $value = self::$value;
            if (sizeof($value)!=0) {
                $in_p = [''];
                foreach ($value as $v) {
                    $in_p[0] .= is::int($v)?'i':'s';
                    array_push($in_p, $v);
                }
                $stmt->bind_param(...$in_p);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $out[] = $row;
            }
            $stmt->close();
            if (isset($out)) {
                return $out;
            } else {
                return false;
            }
        } else {
            system::add_error('sql::fetch()', 'query_fail', '"'.self::$query.'" query failed');
        }
    }

    public function count()
    {
        if ($stmt = self::$connect->prepare(self::$query)) {
            $value = self::$value;
            if (sizeof($value)!=0) {
                $in_p = [''];
                foreach ($value as $v) {
                    $in_p[0] .= is::int($v)?'i':'s';
                    array_push($in_p, $v);
                }
                $stmt->bind_param(...$in_p);
            }
            $stmt->execute();
            $stmt->store_result();
            $result = $stmt->num_rows;
            $stmt->close();
            return $result;
        } else {
            system::add_error('sql::count()', 'query_fail', '"'.self::$query.'" query failed');
        }
    }
}
