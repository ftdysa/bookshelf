<?php

// Some helpers taken from libphutil

/**
 * Access an array index, retrieving the value stored there if it exists or
 * a default if it does not. This function allows you to concisely access an
 * index which may or may not exist without raising a warning.
 *
 * @param   array   Array to access.
 * @param   scalar  Index to access in the array.
 * @param   wild    Default value to return if the key is not present in the
 *                  array.
 * @return  wild    If `$array[$key]` exists, that value is returned. If not,
 *                  $default is returned without raising a warning.
 */
function idx(array $array, $key, $default = null) {
    // isset() is a micro-optimization - it is fast but fails for null values.
    if (isset($array[$key])) {
        return $array[$key];
    }

    // Comparing $default is also a micro-optimization.
    if ($default === null || array_key_exists($key, $array)) {
        return null;
    }

    return $default;
}