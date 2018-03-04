<?php
namespace fruitstudios\linkit\models;

use Craft;

use fruitstudios\linkit\LinkIt;
use fruitstudios\linkit\base\LinkType;
use fruitstudios\linkit\services\LinkItService;

use craft\elements\Entry as CraftEntry;
use craft\base\ElementInterface;

class Entry extends LinkType
{
    // Private
    // =========================================================================

    private $_elementType = CraftEntry::class;
    private $_settingsHtmlPath = 'link-it/types/settings/_element';
    private $_inputHtmlPath = 'link-it/types/input/_element';

    // Public
    // =========================================================================

    public $typeLabel;
    public $sources = '*';
    public $selectionLabel;

    // Static
    // =========================================================================

    // Public Methods
    // =========================================================================

    public function getLabel()
    {
        return $this->typeLabel ?? self::defaultLabel();
    }

    public function getElementType()
    {
        return $this->_elementType;
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['typeLabel', 'string'];
        $rules[] = ['selectionLabel', 'string'];
        return $rules;
    }


    public function getSettingsHtml()
    {
       return Craft::$app->getView()->renderTemplate(
            $this->_settingsHtmlPath,
            [
                'type' => $this,
            ]
        );
    }

    public function getInputHtml($name)
    {
        return Craft::$app->getView()->renderTemplate(
            $this->_inputHtmlPath,
            [
                'name' => $name,
                'type' => $this,
                'link' => $this->getLink(),
            ]
        );
    }

    public function getLink()
    {
        return null;
        // return new Link();
    }

    // Protected Methods
    // =========================================================================

    /**
     * Normalizes the available sources into select input options.
     *
     * @return array
     */
    public function getSourceOptions(): array
    {
        return LinkIt::$plugin->service->getSourceOptions($this->_elementType);
    }

}
