<?php

namespace Spatie\Menu;

use Spatie\Menu\Html\Attributes;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\Conditions as ConditionsTrait;
use Spatie\Menu\Traits\HasHtmlAttributes as HasHtmlAttributesTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;
use Spatie\Menu\Traits\HasTextAttributes as HasAttributesTrait;

class Link implements Item, HasHtmlAttributes, HasParentAttributes, Activatable
{
    use ActivatableTrait;
    use HasHtmlAttributesTrait;
    use HasParentAttributesTrait;
    use ConditionsTrait;
    use HasAttributesTrait;

    /** @var string */
    protected $text;

    /** @var string|null */
    protected $url = null;

    /** @var string */
    protected $prepend = '';

    /** @var string */
    protected $append = '';

    /** @var bool */
    protected $active = false;

    /** @var \Spatie\Menu\Html\Attributes */
    protected $htmlAttributes;
    protected $parentAttributes;

    /**
     * @param string $url
     * @param string $text
     */
    protected function __construct(string $url, string $text)
    {
        $this->url = $url;
        $this->text = $text;
        $this->htmlAttributes = new Attributes();
        $this->parentAttributes = new Attributes();
    }

    /**
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public static function to(string $url, string $text)
    {
        return new static($url, $text);
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $attributes = new Attributes(['href' => $this->url]);
        $attributes->mergeWith($this->htmlAttributes);

        return $this->renderPrepend()."<a {$attributes}>{$this->text}</a>".$this->renderAppend();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
