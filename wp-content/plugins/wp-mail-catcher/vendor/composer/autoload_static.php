<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit43ff077d15826c011f18a7cd43338557
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WpMailCatcher\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WpMailCatcher\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit43ff077d15826c011f18a7cd43338557::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit43ff077d15826c011f18a7cd43338557::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit43ff077d15826c011f18a7cd43338557::$classMap;

        }, null, ClassLoader::class);
    }
}
