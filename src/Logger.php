<?php


namespace gdarko\CDU;

/**
 * Class Logger
 *
 * @package gdarko\CDU
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class Logger extends Base
{
    /**
     * Write log message
     * @param $message
     */
    public function write($message) {
        $message = '['.date('Y-m-d H:i:s').']: '.$message . PHP_EOL;
        $path = $this->logs_path();
        file_put_contents($path, $message, FILE_APPEND);
    }

    /**
     * Return log path
     * @return string
     */
    private function logs_path() {
        return $this->path('.log');
    }
}