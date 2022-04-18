<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Pig Latin with string functions in PHP</title>
    <style>
      body {
        color: green;
        font-family: Arial, Verdana;
      }
    </style>
  </head>
  <body>
      
    <h1>Pig Latin Generator</h1><?php

      function sanitizeString($field) {
        return filter_input(INPUT_GET, $field, FILTER_SANITIZE_STRING);
      }

      $submitPressed = sanitizeString('go');
  
      if (!isset($submitPressed)) {

        $formOut = <<<FORM
    <form action="$_SERVER[PHP_SELF]" method="get">
      <textarea name="inputString" rows="20" cols="40"></textarea>
      <br>
      <input type="submit" name="go" value="Pigify">
    </form>
                      
FORM;

        echo $formOut;
      } else { // else form has been submitted

        // Get the input string and check to see if it contains characters
        $inputData = sanitizeString('inputString');

        if ($inputData) {

            $newPhrase = "";

            //Ensure the input string is all lowercase
            $str = strtolower($inputData);

            // break the input string up into individual words
            $wordList = explode(" ", $str);

            // for each individual word, perform the following tasks
            foreach ($wordList as $word){


            // Strip out all non-letter characters - hint (".,;:'\"? \t\n-()_0..9")
                //Use a regular expression pattern (everything between the //'s)
                //find any character in $word that is not a letter, and replace it with nothing. ->Delete.
                //^ inside of []'s (character set) means stop before you hit this character
                //effectively telling the regular expression to "delete" all but the type of characters in the pattern.
                $word = preg_replace("/[^a-z]/i", "", $word);

                // Check to see if the word has any character's remaining
                if($word){


                // Break up the word into first letter and rest of word
                    $firstLetter = substr($word,0, 1);
                    $restOfWord = substr($word, 1);

                // if first letter is a vowel, leave it in place
                // and append "way" to the end of the word
                // else move the first letter to the end of the word
                // and append "ay"
                    if(strstr("aeiou", $firstLetter)){
                        //first letter is a vowel
                        $newWord = $word . "way";

                    }else{
                        //first letter is a consonant
                        $newWord = $restOfWord . $firstLetter . "ay";
                    }

                    // append the newly created pig Latin word to an output line
                    $newPhrase .= $newWord . " ";

                }

            } //end foreach word

            // output translated pig Latin phrase in the following output line
            echo "<h3 style=\"color:yellow;background-color:navy\">$inputString "
                . "translated into Pig Latin: $newPhrase</h3>\n";


        } else{
          // If the input string was initially blank output the following line
          echo "<h3 style=\"color:yellow;background-color:navy\">Why you no enter text?</h3>";
        }
      } // end if form has been submitted
      ?> 
  </body>
</html>