Version 2.3.0
- raised minimal version of PHP to 7.4
- used typed properties (possible BC break)

Version 2.2.0
- raised minimal version of PHP to 7.3
- deprecated some getters and setters of BookControl and BookPage
- made BookPage::$slug and BookPage::$title writable

Version 2.1.1
- re-added support for Latte 2.5

Version 2.1.0
- dropped support for Nette 2.4

Version 2.0.0
- raised minimal version of PHP to 7.2
- marked BookPagesStorage as final
- BC break: changed parameters of method BookPagesStorage::getIndex
- allowed Nette 3
- BC break: removed property BookControl::$lang
- removed dependency on nexendrie/translation, now it is just suggested
- BC break: BookControl uses translator registered to Latte

Version 1.4.0
- allowed customization of index and page templates
- added conditional book pages

Version 1.3.0
- added missing getter and setter for BookControl::$lang
- made it possible to pass translator to BookControl via constructor (it is optional)
- made BookControl non-abstract, added real property $pages
- added event onRender for BookControl
- added dependency on nexendrie/utils
- BookPagesStorage now extends Nexendrie\Utils\Collection

Version 1.2.0
- used message catalogue for translation by default
- changed ids in templates
- raised minimal version of PHP to 7.1

Version 1.1.1
- updated for nexendrie/translation 0.1
- code cleaning

Version 1.1.0
- added dependency on nexendrie/translation
- moved translating feature to package nexendrie/translation
- require version 2.4 of Nette packages

Version 1.0.2
- changed package's vendor

Version 1.0.1
- allowed setting custom folder for translation
- do logic of Translator::setLang() only if the language is different

Version 1.0
- added support for translations

Version 1.0-RC1
- initial version
