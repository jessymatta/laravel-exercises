<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelEx extends Controller
{
//-------------------------------------START OF API1-------------------------------------------

    //A function that sorts a string according to a specific format. For example: "eA2a1E" becomes "aAeE12"
    public function sort($input_str)
    {
        // Using str_split to convert the input string into an array of its characters
        $pseudo_sorted_array = str_split($input_str);

        //Sorting the array consisting of the characters of the input string while ignoring cases
        sort($pseudo_sorted_array, SORT_NATURAL | SORT_FLAG_CASE);

        //A string that will consist of the sorted numbers of the input string
        $number_part_str = "";

        //i is a variable; it is initialized outside the outside loop because we are going to use its value after the while loop
        $i = 0;

        //In the while loop we are checking for the characters that are integers and adding them to our $number_part_str
        while ($i < count($pseudo_sorted_array) && is_numeric($pseudo_sorted_array[$i])) {
            $number_part_str = $number_part_str . $pseudo_sorted_array[$i];
            $i++;
        }

        //at $i we have our first non numeric character so we are slicing the array to sort the characters according to the required format
        $char_arr = array_slice($pseudo_sorted_array, $i);

        //We are converting the array to a single string by using the method implode()
        $input_str_of_chars = implode($char_arr);

        $arr_grouped_chars = $this->groupMatchingConsecutiveChars($input_str_of_chars);

        //Final string that contains all characters sorted according to the required format
        $str_chars_final = "";
        //Reversing all elements of the arr_grouped_char array and concatinating the outputs to the str_chars_final
        foreach ($arr_grouped_chars as $grouped_str) {
            $new_str = $this->reverseSortString($grouped_str);
            $str_chars_final .= $new_str;
        }

        $final_sorted_str = $str_chars_final . $number_part_str;

        //Returning the results in the required JSON format
        return response()->json([
            "$input_str" => "$final_sorted_str"
        ]);
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
        return $array;
    }


    // Helper function that will take a string and reverve it sorting, this way according to the ASCII code we will have the capitalized letters after the lowercase ones
    private function reverseSortString(string $str)
    {

        // Using str_split to convert string to an array
        $sort = str_split($str);

        //Reverse sorting the array, as mentioned in the function's description
        rsort($sort);

        //converting the array back to a string by using implode() and returning it
        return  implode($sort);
    }

//-------------------------------------START OF API2-------------------------------------------
    //A function that recives a number and returns each place value in the number
    public function placeValue(){
        
    }
}
