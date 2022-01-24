<?php

namespace ICN;

use Helpers\Str;

class Misc
{
    /**
     * @param $fieldArr
     * @param $key
     * @return null|object
     */
    public static function getRepeaterFieldValue($fieldArr, $key)
    {
        $value = null;

        if ( is_array($fieldArr) ) {
            if ( array_key_exists($key, $fieldArr) )
                $value = $fieldArr[$key];
            else {
                foreach ( $fieldArr as $field ) {
                    if ( is_array($field) && array_key_exists($key, $field) ) {
                        $value = $field[$key];
                        break;
                    }
                }
            }

        }
        return $value;
    }

    /**
     * Compute page summary
     * @param $content
     * @param $charsNum
     * @return string
     */
    public static function computeSummary($content, $charsNum)
    {
        return Str::limit($content, $charsNum);
    }

}