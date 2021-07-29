<?php

namespace Drupal\rot13_textfield;

/**
 * Class ROT13Textfield
 * @package Drupal\rot13_textfield\Plugin\Field\FieldFormatter\Drupal\rot13_textfield
 *
 * @description Provides variables and functions for applying a ROT13 filter to
 *   plain text.
 */
class ROT13Textfield {

  /**
   * An array with the letters of the alphabet as keys, and the associated
   *   number, zero index, as each value.
   *
   * @var int[] $alphabet
   *
   */
  public static $alphabet = [
    'a' => 0,
    'b' => 1,
    'c' => 2,
    'd' => 3,
    'e' => 4,
    'f' => 5,
    'g' => 6,
    'h' => 7,
    'i' => 8,
    'j' => 9,
    'k' => 10,
    'l' => 11,
    'm' => 12,
    'n' => 13,
    'o' => 14,
    'p' => 15,
    'q' => 16,
    'r' => 17,
    's' => 18,
    't' => 19,
    'u' => 20,
    'v' => 21,
    'w' => 22,
    'x' => 23,
    'y' => 24,
    'z' => 25,
  ];

  /**
   * Take a plain text string and apply a custom ROT13 function to it.
   *
   * Each letter will be shifted 13 letters in the alphabet.
   *
   * @param string $value
   * @return string
   */
  public static function covertToRot13(string $value): string {
    $new_value = '';

    if (!empty($value)) {
      // Flip the $alphabet array instead of having two separate arrays to
      // manage.
      $alphabetIndexes = array_flip(self::$alphabet);

      $chars = str_split($value);

      // This will be the updated string where letters have been rotated 13
      // places.
      $new_value = '';

      // Process each character in the string, rotating letters 13 places.
      foreach ($chars as $char) {
        // A character's new alphabet number after being rotated 13 places.
        // Number characters and special characters will return NULL.
        $number = self::getRot13Number($char);

        // If $number isn't set, or isn't an int, that means the $char isn't a
        // letter.
        if (!isset($number) || !is_int($number)) {
          $new_value .= $char;
        }
        else {
          // Add the rotated character to the $new_value, making it uppercase if
          // the original $char was.
          $new_value .= ctype_upper($char) ?
            strtoupper($alphabetIndexes[$number]) :
            $alphabetIndexes[$number];
        }
      }
    }

    return $new_value;
  }

  /**
   * Get the number associated with a letter, then increase it by 13.
   *
   * Will stick to the 0-25 range, to ensure a letter will correspond with the
   * returned number.
   *
   * @param string $letter
   * @return int|null
   *
   */
  public static function getRot13Number(string $letter): ?int {
    $number = self::$alphabet[strtolower($letter)];

    // Check to make sure the provided string character, $letter, had an
    // associated number. Ensures that $letter wasn't a non-letter character.
    if (isset($number)) {
      $new_number = $number + 13;

      // If the $new_number is greater than 25, subtract 26 to ensure it stays
      //in the 0-25 range.
      $new_number = $new_number > 25 ? $new_number - 26 : $new_number;
    }
    else {
      // The provided character, $letter, wasn't a letter. It was either a
      // number character or a special character, and therefore, shouldn't be
      // altered.
      $new_number = NULL;
    }

    return $new_number;
  }
}
