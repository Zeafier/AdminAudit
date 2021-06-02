<?php

function clean($input) {
    // Removes slashes from input data
    $input = stripslashes($input);
    
  // Typically you would use either strip_tags or htmlspecialchars
    // depending on whether you want to remove the HTML characters
    // or just neutralize it.
  // Removes all the html tags from input data
    $input = strip_tags($input);
    // Escapes html characters from input data
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
  return $input;
}
   
?>