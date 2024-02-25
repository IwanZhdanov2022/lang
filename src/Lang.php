<?php

namespace Iwan07\Lang;
use Iwan07\Lang\Exception\NoMessageLangException;
use Iwan07\Lang\Exception\UnexpectedFormatLangException;

class Lang
{
    static private string $language = 'ru';
    private string $scriptPath = '';
    private array $texts = [];

    public function __construct()
    {
        $this->getScriptPath();
        $this->loadLanguageFiles();
    }

    public static function setLanguage(string $language): void
    {
        self::$language = $language;
    }

    public function __get(string $label): string
    {
        return $this->msg($label);
    }

    public function msg(string $label, ?string $default=null): string
    {
        $result = $this->getMessageByLabel($label, $default);
        if (is_array($result)) {
            $result = $this->unwrapMessage($result, 1, false, $label);
        }
        return $result;
    }

    public function num(int $count, string $label, bool $includeNumber=true): string
    {
        $result = $this->getMessageByLabel($label);
        if (is_array($result)) {
            $result = $this->unwrapMessage($result, $count, $includeNumber, $label);
        } else {
            if ($includeNumber) {
                $result = $count . ' ' . $result;
            }
        }
        return $result;
    }

    private function getScriptPath(): void
    {
        foreach (debug_backtrace() as $trace) {
            if ($trace['file'] === __FILE__) {
                continue;
            }
            $this->scriptPath = $trace['file'];
        }
    }

    private function getLanguageFileList(): array
    {
        $list = [];
        $folders = explode(DIRECTORY_SEPARATOR, $this->scriptPath);
        array_pop($folders);
        $langFileName = 'lang_'.self::$language.'.php';
        while (count($folders) > 0) {
            $list[] = implode(DIRECTORY_SEPARATOR, $folders) . DIRECTORY_SEPARATOR . $langFileName;
            array_pop($folders);
        }
        return $list;
    }

    private function loadLanguageFiles(): void
    {
        $this->texts = [];
        $langFileList = $this->getLanguageFileList();
        foreach ($langFileList as $path) {
            if (is_file($path)) {
                $this->texts = array_merge(
                    require $path,
                    $this->texts
                );
            }
        }
    }

    private function getMessageByLabel(string $label, ?string $default=null): string|array
    {
        if (!array_key_exists($label, $this->texts)) {
            if ($default !== null) {
                return $default;
            }
            throw new NoMessageLangException("No message with label '$label'");
        }
        return $this->texts[$label];
    }

    private function unwrapSlavicMessage(array $message, int $count): string
    {
        $n1 = (int)($count % 10);
        $n2 = (int)(($count % 100) / 10);
        if ($n2 !== 1) {
            if ($n1 === 1) {
                return $message[0];
            }
            if ($n1 >= 2 && $n1 <= 4) {
                return $message[1];
            }
        }
        return $message[2];
    }

    private function unwrapRomanMessage(array $message, int $count): string
    {
        if ($count === 1) {
            return $message[0];
        }
        return $message[1];
    }

    private function unwrapMessage(array $message, int $count, bool $includeNumber, string $label): string
    {
        if (
            count($message) === 3
            && is_string($message[0])
            && is_string($message[1])
            && is_string($message[2])
        ) {
            $str = $this->unwrapSlavicMessage($message, $count);
            if ($includeNumber) {
                $str = $count . " " . $str;
            }
            return $str;
        }
        if (
            count($message) === 2
            && is_string($message[0])
            && is_string($message[1])
        ) {
            $str = $this->unwrapRomanMessage($message, $count);
            if ($includeNumber) {
                $str = $count . " " . $str;
            }
            return $str;
        }
        throw new UnexpectedFormatLangException("Unexpected message format for label '$label'");
    }
}