<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelEx extends Controller
{
    //-------------------------------------START OF API1-------------------------------------------

    //A function that sorts a string according to a specific format. For example: "eA2a1E" becomes "aAeE12"
    public function sort(string $input_str)
    {
        // Using str_split to convert the input string into an array of its characters
        $positionseudo_sorted_array = str_split($input_str);

        //Sorting the array consisting of the characters of the input string while ignoring cases
        sort($positionseudo_sorted_array, SORT_NATURAL | SORT_FLAG_CASE);

        //A string that will consist of the sorted numbers of the input string
        $number_part_str = "";

        //i is a variable; it is initialized outside the outside loop because we are going to use its value after the while loop
        $i = 0;

        //In the while loop we are checking for the characters that are integers and adding them to our $number_part_str
        while ($i < count($positionseudo_sorted_array) && is_numeric($positionseudo_sorted_array[$i])) {
            $number_part_str = $number_part_str . $positionseudo_sorted_array[$i];
            $i++;
        }

        //at $i we have our first non numeric character so we are slicing the array to sort the characters according to the required format
        $char_arr = array_slice($positionseudo_sorted_array, $i);

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
    //A function that receives a number and returns each place value in the number
    public function placeValue(int $input_int)
    {
        //copying the input, because we want to return it in the response and we will be modifying its value throughout the code
        $input_int_copy = $input_int;
        //giving an arbitrary value to $remainder, because I couldn't declare the variable without initializing it. This value does not mean anything
        $remainder = -999;
        $position = 1;
        $iterator = 0;
        $array_to_return = [];

        while ($input_int_copy != 0) {
            $remainder = $input_int_copy % 10;
            $position = pow(10, $iterator++);
            array_push($array_to_return, $remainder * $position);
            $input_int_copy = intdiv($input_int_copy, 10);
        }

        //we are reversing the array to have the exact format that is required, "39" -> [30, 9] not [9, 30]
        return response()->json([
            $input_int => array_reverse($array_to_return)
        ]);
    }

    //-------------------------------------START OF API3-------------------------------------------
    //A function that replaces the numbers in a string with their binary form.
    public function convertToBinary(string $input_string)
    {

        /*The preg_match_all() function returns the number of matches of a pattern that were found in a string 
        and populates a variable with the matches that were found. Here a regex expression is used to split the string at the number, the fisrt part matches the numbers, the second one alphabetical characters with dots and spaces*/

        preg_match_all('/([0-9]+|[a-zA-Z \.]+)/', $input_string, $matches);

        $array_split_at_numbers = $matches[0];
        $str_to_return = "";

        //looping through the $array_split_at_numbers and converting the numbers parts to binary using php's built-in function decbin()
        foreach ($array_split_at_numbers as $word) {

            if (is_numeric($word)) {
                $str_to_return .= decbin($word);
            } else {
                $str_to_return .= $word;
            }
        }

        return response()->json([
            $input_string => $str_to_return
        ]);
    }

    //-------------------------------------START OF API4-------------------------------------------
    public function prefixEvalution($input_str)
    {

        //split the inputted string at spaces and assign the result to $array_expression
        $array_expression = explode(" ", $input_str);
        $reversed_exp_array = array_reverse($array_expression);
        $operators_array = ["+", "-", "*", "/"];

        //We will be using php's built-in arrays as a Stack, through the array_push() and array_pop() methods
        $my_stack = [];

        foreach ($reversed_exp_array as $element) {

            //Check if the element is an operator, if so pop 2 elements from the stack, evaluate the results, then push the result back to the stack
            if (in_array($element, $operators_array)) {
                $operator_1 = array_pop($my_stack);
                $operator_2 = array_pop($my_stack);
                $result = $operator_1 . $element . $operator_2;
                $result_as_integer = eval("return ($result);");
                array_push($my_stack, $result_as_integer);
            } else {
                //if the element is not an operator just push it to the stack
                array_push($my_stack, $element);
            }
        }
        //returning the last element in the stack as it will be equal to the evaluation of the expression
        return response()->json([
            $input_str => array_pop($my_stack)
        ]);
    }
}
