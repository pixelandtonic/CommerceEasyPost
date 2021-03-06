<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4b592db52436cc328f117d986390d4bb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PhpUnitsOfMeasure\\' => 18,
        ),
        'D' => 
        array (
            'DVDoug\\BoxPacker\\' => 17,
        ),
        'C' => 
        array (
            'CommerceEasyPost\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PhpUnitsOfMeasure\\' => 
        array (
            0 => __DIR__ . '/..' . '/triplepoint/php-units-of-measure/source',
        ),
        'DVDoug\\BoxPacker\\' => 
        array (
            0 => __DIR__ . '/..' . '/dvdoug/boxpacker/src',
        ),
        'CommerceEasyPost\\' => 
        array (
            0 => __DIR__ . '/../..' . '/CommerceEasyPost',
        ),
    );

    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'EasyPost' => 
            array (
                0 => __DIR__ . '/..' . '/easypost/easypost-php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4b592db52436cc328f117d986390d4bb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4b592db52436cc328f117d986390d4bb::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit4b592db52436cc328f117d986390d4bb::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
