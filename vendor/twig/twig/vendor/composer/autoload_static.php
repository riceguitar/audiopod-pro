<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit70babd08e5c7abdf6fdfb2c13f24c639
{
    public static $files = array (
        '92c8763cd6170fce6fcfe7e26b4e8c10' => __DIR__ . '/..' . '/symfony/phpunit-bridge/bootstrap.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Bridge\\PhpUnit\\' => 23,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Bridge\\PhpUnit\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/phpunit-bridge',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/../..' . '/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit70babd08e5c7abdf6fdfb2c13f24c639::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit70babd08e5c7abdf6fdfb2c13f24c639::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit70babd08e5c7abdf6fdfb2c13f24c639::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit70babd08e5c7abdf6fdfb2c13f24c639::$classMap;

        }, null, ClassLoader::class);
    }
}