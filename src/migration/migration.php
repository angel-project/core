<?php

  /*
  |--------------------------------------------------------------------------
  | migration::define a database table structure
  |--------------------------------------------------------------------------
  |
  | Render a view:
  |
  | migration::table('table_name', function($table){
  |   $table->integer('a');
  |   $table->boolean('b');
  | });
  |
  */

namespace angel;

class migration
{
    public $query = 'CREATE TABLE ';

    private $names = [];

    public static function table($name, $define)
    {
        $log = json_decode(file::read(user::dir().'/migration/log.json'), true);
        if (!is::in($name, $log)) {
            $query = substr(call_user_func_array($define, [new migration($name)])->query, 0, -1).')';
            sql::run($query);
            $log[] = $name;
            file::write([
              user::dir().'/migration/log.json' => json_encode($log)
            ]);
        }
    }

    public function __construct($n)
    {
        $this->query .= $n.' (';
    }

    public function int($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' INT,';
            } else {
                $this->query .= $n.' INT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function tinyint($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' TINYINT,';
            } else {
                $this->query .= $n.' TINYINT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function smallint($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' SMALLINT,';
            } else {
                $this->query .= $n.' SMALLINT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function bigint($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' BIGINT,';
            } else {
                $this->query .= $n.' BIGINT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function text($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' TEXT,';
            } else {
                $this->query .= $n.' TEXT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function tinytext($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' TINYTEXT,';
            } else {
                $this->query .= $n.' TINYTEXT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function longtext($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' LONGTEXT,';
            } else {
                $this->query .= $n.' LONGTEXT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function boolean($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' BOOLEAN,';
            } else {
                $this->query .= $n.' BOOLEAN('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function float($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' FLOAT,';
            } else {
                $this->query .= $n.' FLOAT('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function double($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' DOUBLE,';
            } else {
                $this->query .= $n.' DOUBLE('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function date($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' DATE,';
            } else {
                $this->query .= $n.' DATE('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function datetime($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' DATETIME,';
            } else {
                $this->query .= $n.' DATETIME('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function timestamp($n, $length = null)
    {
        if (!is::in($n, $this->names)) {
            if ($length===null) {
                $this->query .= $n.' TIMESTAMP,';
            } else {
                $this->query .= $n.' TIMESTAMP('.$length.'),';
            }
            $this->names[] = $n;
        }
    }

    public function primary_key($n)
    {
        if (is::in($n, $this->names)) {
            $this->query .= 'PRIMARY KEY ('.$n.' ),';
        }
    }
}
