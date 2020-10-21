<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc3a1e232919a7798f1f05108c48e219
{
    public static $classMap = array (
        'WPML\\CF7\\Constants' => __DIR__ . '/../..' . '/classes/constants.php',
        'WPML\\CF7\\Language_Metabox' => __DIR__ . '/../..' . '/classes/language-metabox.php',
        'WPML\\CF7\\Shortcodes' => __DIR__ . '/../..' . '/classes/shortcodes.php',
        'WPML\\CF7\\Translations' => __DIR__ . '/../..' . '/classes/translations.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitfc3a1e232919a7798f1f05108c48e219::$classMap;

        }, null, ClassLoader::class);
    }
}