<?php
  $test_map_ary = ary::map([1,2,3],function($key,$value){
    return $value*3;
  });
  assert($test_map_ary[0]==3&&$test_map_ary[1]==6&&$test_map_ary[2]==9);

  $test_filter_ary = ary::filter([1,2,3],function($key,$value){
    return $value>2;
  });
  assert($test_filter_ary[2]==3);

  $test_merge_ary = ary::merge([[1,2,3],[4,5,6]]);
  assert($test_merge_ary[0]=1&&$test_merge_ary[1]=2&&$test_merge_ary[2]=3
     &&$test_merge_ary[3]=4&&$test_merge_ary[4]=5&&$test_merge_ary[5]=6);

  $test_size_ary = ary::size([1,2,3]);
  assert($test_size_ary==3);

  $test_last_ary = ary::size([1,2,3]);
  assert($test_last_ary==3);

  $test_flat_ary = ary::flat([1,2,3,[4,5,[6]]]);
  assert($test_flat_ary[0]==1&&$test_flat_ary[1]==2&&$test_flat_ary[2]==3&&
  $test_flat_ary[3]==4&&$test_flat_ary[4]==5&&$test_flat_ary[5]==6);

  echo "Array Test Finished!"."<br>";
?>
