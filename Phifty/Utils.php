<?php

namespace Phifty;

class Utils
{

    public static function system($command)
    {
        system( $command ) !== false or die('execution failed.');
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
            if ($file != "." && $file != "..") static::rrmdir("$dir/$file");
            rmdir($dir);
        } elseif (file_exists($dir)) unlink($dir);
    }

    public static function rcopy($src, $dst)
    {
        if (file_exists($dst)) static::rrmdir($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
            if ($file != "." && $file != "..") static::rcopy("$src/$file", "$dst/$file");
        } elseif (file_exists($src)) copy($src, $dst);
    }

    public static function array_get_rand( $elems )
    {
        return $elems[ array_rand( $elems ) ];
    }

    // recursive
    public static function array_to_object($array)
    {

        if (!is_array($array))

            return $array;

        $object = new \stdClass();
        if (is_array($array) && count($array) > 0) {

            foreach ($array as $name=>$value) {
                $name = strtolower(trim($name));
                if (!empty($name))
                    $object->$name = self::array_to_object($value);

            }

            return $object;

        } else {
            return FALSE;
        }
    }

    public static function encode_url($unencoded_url) {
        return preg_replace_callback('#://([^/]+)/([^?\#]+)#', function ($match) {
                return '://' . $match[1] . '/' . join('/', array_map('rawurlencode', explode('/', $match[2])));
            }, $unencoded_url);
    }

}
