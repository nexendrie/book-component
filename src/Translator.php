<?php
namespace Nexendrie\BookComponent;

use Nette\Neon\Neon,
    Nette\Utils\Arrays,
    Nette\Localization\ITranslator;

/**
 * Basic Translator for BookControl
 *
 * @author Jakub Konečný
 * @property string $lang
 * @property string $folder
 */
class Translator implements ITranslator {
  use \Nette\SmartObject;
  
  /** @var string */
  protected $lang = "en";
  /** @var array */
  protected $texts = null;
  /** @var string */
  protected $folder = __DIR__ . "/lang";
  
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
    if($lang !== $this->lang) {
      $this->lang = $lang;
      $this->texts = null;
      $this->loadTexts();
    }
  }
  
  /**
   * @return string
   */
  function getFolder() {
    return $this->folder;
  }
  
  /**
   * @param string $folder
   */
  function setFolder($folder) {
    $this->folder = $folder;
  }
  
  /**
   * @return void
   */
  protected function loadTexts() {
    if(!is_null($this->texts)) return;
    $default = Neon::decode(file_get_contents("$this->folder/en.neon"));
    $lang = [];
    if($this->lang != "en" AND is_file("$this->folder/{$this->lang}.neon")) {
      $lang = Neon::decode(file_get_contents("$this->folder/{$this->lang}.neon"));
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