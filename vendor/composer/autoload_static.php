<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3bc9fd94494fb62252304ca1803357ea
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3bc9fd94494fb62252304ca1803357ea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3bc9fd94494fb62252304ca1803357ea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3bc9fd94494fb62252304ca1803357ea::$classMap;

        }, null, ClassLoader::class);
    }
}
