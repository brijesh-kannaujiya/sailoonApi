<?php

// Function to generate OTP 
function generateNumericOTP($n)
{
  $result = "";
  $generator ="135792468";
  for ($i = 1; $i <= $n; $i++) {
    $result .= substr($generator, (rand() % (strlen($generator))), 1);
  }
  return $result;
}
?>