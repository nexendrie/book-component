<?php
namespace JK\BookComponent;

use Nette\Neon\Neon,
    Nette\Utils\Arrays;

/**
 * Basic Translator for BookControl
 *
 * @author Jakub Konečný
 * @property string $lang
 */
class Translator implements \Nette\Localization\ITranslator {
  use \Nette\SmartObject;
  
  /** @var string */
  protected $lang = "en";
  /** @var array */
  protected $texts = null;
  
  /**
   * @return string
   */
  function getLang() {
    return $this->lang;
  }
  
  /**
   * @param string $lang
   */
  function setLang($lang) {
    $this->lang = $lang;
    $this->texts = null;
    $this->loadTexts();
  }
  
  /**
   * @return void
   */
  protected function loadTexts() {
    if(!is_null($this->texts)) return;
    $default = Neon::decode(file_get_contents(__DIR__ . "/lang/en.neon"));
    $lang = [];
    if($this->lang != "en" AND is_file(__DIR__ . "/lang/{$this->lang}.neon")) {
      $lang = Neon::decode(file_get_contents(__DIR__ . "/lang/{$this->lang}.neon"));
    }
    $this->texts = array_merge($default, $lang);
  }
  
  /**
   * @param string $message
   * @param int $count
   * @return string
   */
  function translate($message, $count = 0) {
    if(substr($message, 0, 5) != "book.") return "";
    $this->loadTexts();
    return Arrays::get($this->texts, substr($message, 5), "");
  }
}
?>