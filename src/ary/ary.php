<?php

  /*
  |--------------------------------------------------------------------------
  | ary::array operations
  |--------------------------------------------------------------------------
  |
  | map an array:
  |
  | ary::map($array, function($key,$value){
  |   //your code here
  |   return $str;
  | });
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | filter an array:
  |
  | ary::filter($array, function($key,$value){
  |   //your code here
  |   return true/false;
  | });
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | merge arrays:
  |
  | ary::merge([
  |   $array_1,
  |   $array_2,
  |   $array_3
  | ]);
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | flatten an array:
  |
  | ary::flat($array);
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | get array size:
  |
  | ary::size($array);
  |
  | returns: int
  |
  |--------------------------------------------------------------------------
  |
  | get last element of an array:
  |
  | ary::last($array);
  |
  | returns: str/int
  |
  |
  |
  */

namespace angel;

class ary
{

    //function used to put all key elements into the
    //given and assign returning values to array's value
    public static function map(array $array, $method)
    {
        //used to make sure the method is valid
        if (gettype($method)==='object') {
            foreach ($array as $key=>$value) {
                //assign return values to value of the array
                $array[$key] = call_user_func_array($method, [$key,$value]);
            }
            //return the modified array
            return $array;
        } else {
            //send error messages if the method is not valid
            system::add_error('ary::map()', 'missing_function', 'second parameter must be a function object');
        }
    }

    //The given method determines if each element in the array
    //satisfies the requirement of the method(method returns true)
    public static function filter(array $array, $method)
    {
        //if the method is valid
        if (gettype($method)==='object') {
            $out = [];
            foreach ($array as $key=>$value) {
                //true if key and value satisfy the method
                if (call_user_func_array($method, [$key,$value])) {
                    $out[$key] = $value;
                }
            }
            return $out;
        } else {
            //send error message if the given method is not valid
            system::add_error('ary::filter()', 'missing_function', 'second parameter must be a function object');
        }
    }
    //merge all the subarrays into a big array
    public static function merge(array $array, array $b = [])
    {
        if (!is::empty($b)) {
            $array = array($array,$b);
        }
        return call_user_func_array('array_merge', $array);
    }

    //pick out all the single element in the array and
    //combine these elements into a whole array
    public static function flat(array $array)
    {
        $out = [];
        foreach ($array as $key=>$value) {
            if (is_array($value)) {
                //use recursion to get to the next array
                $out = array_merge($out, self::flat($value));
            } else {
                //add the value to the back of the array
                //if the value is not an array
                $out[] = $value;
            }
        }
        //return the resulting array
        return $out;
    }

    //get the size of the array
    public static function size(array $array)
    {
        return sizeof($array);
    }

    //return the last element of the array
    public static function last(array $array)
    {
        return array_values(array_slice($array, -1))[0];
    }

    //return the first element of the array
    public static function first(array $array)
    {
        return array_values(array_slice($array, 0))[0];
    }
}
