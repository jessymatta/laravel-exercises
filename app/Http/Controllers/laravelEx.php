<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelEx extends Controller
{

    public function sort()
    {
        // $input_str = '16E7AeB2ce6880aA9a';
        $input_str = '846ZIbo';

        // Using str_split to convert the input string into an array of its characters
        $pseudo_sorted_array = str_split($input_str);

        //Sorting the array consisting of the characters of the input string while ignoring cases
        sort($pseudo_sorted_array, SORT_NATURAL | SORT_FLAG_CASE);

        //Astring that will consist of the sorted numbers of the input string
        $number_part_str = "";

        //i is a variable; it is initialized outside the outside loop because we are going to use its value after the while loop
        $i = 0;

        //In the while loop we are checking for the characters that are integers and adding them to our $number_part_str
        while ($i < count($pseudo_sorted_array) && is_numeric($pseudo_sorted_array[$i])) {
            echo $pseudo_sorted_array[$i] . "is a numberrr \n ";
            $number_part_str = $number_part_str . $pseudo_sorted_array[$i];
            $i++;
        }


        echo $number_part_str, "\n";
        echo "index of the first letter  " . $i . "\n";

        echo "COUNT " . count($pseudo_sorted_array) . "\n";

        //at $i we have our first non numeric character so we are slicing the array to sort the characters according to the required format
        $char_arr = array_slice($pseudo_sorted_array, $i);
        print_r($char_arr);

        //We are converting the array to a single string by using the method implode()
        $input_str_of_chars = implode($char_arr);
        echo $input_str_of_chars;

        $arr_grouped_chars = $this->groupMatchingConsecutiveChars($input_str_of_chars);
        print_r($arr_grouped_chars);
        echo "DONE";
        echo(gettype($arr_grouped_chars));


    }



    // Helper function that will group matching consecutive characters while ignoring the case
    private function groupMatchingConsecutiveChars(string $str)
    {
        $array = [];
        $lastChar = "";
        $temp = "";

        foreach (str_split($str) as $char) {
            if (strcasecmp($char, $lastChar) != 0) {
                unset($temp);
                $array[] = &$temp;
                $temp = $char;
                $lastChar = $char;
            } else {
                $temp .= $char;
            }
        }
        // print_r($array);
        return $array;
    }
}
