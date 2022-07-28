<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit66239fac510985ced1fce9d929ac5936
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Grav\\Plugin\\ThemesFromGit\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Grav\\Plugin\\ThemesFromGit\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Grav\\Plugin\\ThemesFromGitPlugin' => __DIR__ . '/../..' . '/themes-from-git.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit66239fac510985ced1fce9d929ac5936::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit66239fac510985ced1fce9d929ac5936::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit66239fac510985ced1fce9d929ac5936::$classMap;

        }, null, ClassLoader::class);
    }
}
