<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite548676bbdccc568b4df43f7ae22f472
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'computerundsound\\culibrary\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'computerundsound\\culibrary\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite548676bbdccc568b4df43f7ae22f472::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite548676bbdccc568b4df43f7ae22f472::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
