<?php
/**
 * I18n Service.
 */

declare(strict_types=1);

namespace Atk4\I18n;

use Symfony\Component\Translation\Formatter\MessageFormatterInterface;
use Symfony\Component\Translation\Loader\CsvFileLoader;
use Symfony\Component\Translation\Loader\IniFileLoader;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Loader\PoFileLoader;
use Symfony\Component\Translation\Loader\QtFileLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;

class Service
{
    /** @var Service */
    private static $instance;

    /** @var Translator */
    private $translator;

    /** @var string[] */
    private $fileType = [
        'php' => PhpFileLoader::class,
        'yaml' => YamlFileLoader::class,
        'po' => PoFileLoader::class,
        'csv' => CsvFileLoader::class,
        'json' => JsonFileLoader::class,
        'xlf' => XliffFileLoader::class,
        'ini' => IniFileLoader::class,
        'mo' => MoFileLoader::class,
        'qt' => QtFileLoader::class,
    ];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initialise service.
     *
     * Create Translator instance used for this service. You can supply your own MessageFormatter, if not one will be create by default.
     * Supply $cachePath where you would like to store your translation cache file. Caching translation file make translation faster and
     * should be used in production.
     *
     * When $cachePath is supply, adding resources language file will be load once and cache will be generated.
     * The translator will use cache file when available for subsequent need for resources file.
     *
     * In development mode, you can set $clearCache to true to delete previous caches.
     */
    public static function init(string $locale, MessageFormatterInterface $formatter = null, string $cachePath = null, array $cacheOptions = [], bool $clearCache = false): void
    {
        if ($clearCache && $cachePath) {
            $iterator = new \FilesystemIterator($cachePath);
            $files = new \RegexIterator($iterator, '/(?:catalogue.' . $locale . ')/');
            foreach ($files as $file) {
                unlink($file->getRealPath());
            }
        }

        self::getInstance()->translator = new Translator($locale, $formatter, !$clearCache ? $cachePath : null, $clearCache, $cacheOptions);
    }

    public static function getTranslator(): Translator
    {
        return self::getInstance()->translator;
    }

    /**
     * Add files resource to the translator.
     * Resources is a collection of directory paths where translation file are located.
     *
     * Directory structure must follow this convention i.e. one directory for each locale.
     *  /- languages
     *      /- en
     *      /- fr
     *
     * File name must follow format: {domain}.{locale}.{file format}: btn.en.php or btn.en.yml
     * of when using the intl icu format: {domain}+intl-icu.{locale}.{file format}: btn+intl-icu.en.php
     *
     * Read more on the ice message format: https://symfony.com/index.php/doc/current/translation/message_format.html
     */
    public static function addResource(string $resourcePath, string $locale, string $fileType): void
    {
        self::getInstance()->setResource($resourcePath, $locale, $fileType);
    }

    /**
     * Add fallback locales to the translator.
     */
    public static function addFallbackLocales(array $locales): void
    {
        self::getInstance()->setFallbackLocales($locales);
    }

    /**
     * Configuring translate for fallback.
     */
    protected function setFallbackLocales(array $locales): void
    {
        $this->translator->setFallbackLocales($locales);
    }

    /**
     * Configuring translator for resources files.
     */
    protected function setResource(string $resourcePath, string $locale, string $fileType): void
    {
        // check if resources is supported
        if (!in_array($fileType, array_keys($this->fileType), true)) {
            $this->throwException('File type is not supported', ['type' => $fileType]);
        }

        if (!is_dir($resourcePath . '/' . $locale)) {
            $this->throwException('Unable to load locale resource from path.', ['locale' => $locale, 'path' => $resourcePath]);
        }

        $loader = $this->fileType[$fileType];
        $this->translator->addLoader($fileType, new $loader());

        $iterator = new \FilesystemIterator($resourcePath . '/' . $locale);
        $files = new \RegexIterator($iterator, '/.(' . $fileType . ')$/');
        foreach ($files as $file) {
            $name = $file->getBasename('.' . $fileType);
            [$domain, $locale] = explode('.', $name);
            self::getInstance()->translator->addResource($fileType, $file->getPathname(), $locale, $domain);
        }
    }

    private function throwException(string $msg, array $moreInfos = [])
    {
        if (class_exists(\Atk4\Ui\Exception::class)) {
            $e = new \Atk4\Ui\Exception($msg);
            if ($moreInfos) {
                foreach ($moreInfos as $key => $info) {
                    $e->addMoreInfo($key, $info);
                }
            }

            throw $e;
        } else {
            throw new \Exception($msg);
        }
    }
}
