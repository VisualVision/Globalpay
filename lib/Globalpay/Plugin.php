<?php

namespace Globalpay;

use Pimcore\API\Plugin as PluginLib;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    public function init()
    {
        parent::init();
    }

    public static function install()
    {
        return true;
    }

    public static function uninstall()
    {
        return true;
    }

    public static function isInstalled()
    {
        return true;
    }

    /**
     * get translation directory
     *
     * @return string
     */
    public static function getTranslationFileDirectory()
    {
        return PIMCORE_PLUGINS_PATH . '/Globalpay/static/texts';
    }

    /**
     * get translation file
     *
     * @param string $language
     * @return string path to the translation file relative to plugin directory
     */
    public static function getTranslationFile($language)
    {
        if (is_file(self::getTranslationFileDirectory() . "/$language.csv")) {
            return "/Globalpay/static/texts/$language.csv";
        } else {
            return '/Globalpay/static/texts/en.csv';
        }
    }

    /**
     * get translate
     *
     * @param $lang
     * @return \Zend_Translate
     */
    public static function getTranslate($lang = null)
    {
        if (self::$_translate instanceof \Zend_Translate) {
            return self::$_translate;
        }

        if (is_null($lang)) {
            try {
                $lang = \Zend_Registry::get('Zend_Locale')->getLanguage();
            } catch (\Exception $e) {
                $lang = 'en';
            }
        }

        self::$_translate = new \Zend_Translate(
            'csv',
            PIMCORE_PLUGINS_PATH . self::getTranslationFile($lang),
            $lang,
            ['delimiter' => ',']
        );

        return self::$_translate;
    }
}
