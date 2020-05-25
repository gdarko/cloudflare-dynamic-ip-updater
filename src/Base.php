<?php

namespace gdarko\CDU;

/**
 * Class Base
 *
 * @package gdarko\CDU
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class Base
{
    /**
     * Return path file from local storage
     *
     * @param  null  $file
     *
     * @return string
     */
    protected function path($file = null)
    {
        $path = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'storage';
        if ( ! file_exists($path)) {
            mkdir($path);
        }
        if ( ! is_null($file)) {
            $path = $path.DIRECTORY_SEPARATOR.$file;
        }

        return $path;
    }
}