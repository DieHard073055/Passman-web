<?php

function generate_pass($string_length=6, $seed=-1, $num_pass=1){
  $alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
	$symbols = ['!','@','#','$','%','^','*','(',')','_','-','+','=','{','}','[',']',':',';',',','.','?','|','~'];
  $values = [];
  srand((float)ord($seed));
  $randval = rand();

  for ($passwords=0; $passwords < $num_pass; $passwords++) {
    $output="";
    for ($letters=0; $letters < $string_length; $letters++) {
      $type = rand(0, 3);
      switch ($type) {
        case 0:
          $output .= $alpha[rand(0, count($alpha)-1)];
          break;
        case 1:
          $output .= strtoupper($alpha[rand(0, count($alpha)-1)]);
          break;
        case 2:
          $output .= rand(0, 9);
          break;
        case 3:
          $output .= $symbols[rand(0, count($symbols)-1)];
          break;

      }
    }
    //echo $output. "<br/>";
    array_push($values, $output);

  }
  return $values;

  //echo json_encode($symbols);
}
