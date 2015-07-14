<?php

namespace Rosswilson252\Html;


class ElementBuilder
{

    /**
     * The HTML builder instance.
     *
     * @var \Rosswilson252\Html\HtmlBuilder
     */
    protected $html;

    /**
     * Starting part of the tag
     * 
     * @var type 
     */
    protected $tag = '';

    /**
     * Is the element a void (self-closing) element
     * e.g. <div></div> = false | <input /> = true
     * 
     * @var boolean 
     */
    protected $void = false;

    /**
     * Attributes for the element
     * 
     * @var array 
     */
    protected $attributes = [];

    /**
     * What the element contains. (Only used when $void == false)
     * 
     * @var string 
     */
    protected $content = '';

    /**
     * Create new instance of Element Builder
     * 
     * @param \Rosswilson252\Html\HtmlBuilder $html
     * @param string  $tag
     * @param boolean $void
     * @param array   $attributes
     * @param mix     $content
     */
    public function __construct($tag = '', $void = false, $attributes = [], $content = '')
    {
        $this->html = new HtmlBuilder;

        $this->tag = $tag;
        $this->void = $void;
        $this->attributes = $attributes;
        $this->content = $content;
    }

    /**
     * Set the type of tag and whether it is void ( a singleton tag )
     * 
     * @param string $tag
     * @param boolean $singleton
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    public function tag($tag, $void = false)
    {
        $this->tag = $tag;

        return $this;
    }

    public function attributes($attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Generate HTML and return as string
     * 
     * @return string
     */
    public function generate()
    {
        return $this->_build();
    }

    /**
     * Build the HTML element
     * 
     * @return type
     */
    protected function _build()
    {
        $tag = $this->formatTag();
        $open = "<$tag" . (empty($this->attributes) ? '>' : ' ' . $this->html->attributes($this->attributes) . '>');

        if ($this->void) {
            return $open . ' />';
        }

        return $open . $this->content . "</$tag>";
    }

    /**
     * Remove HTML tag characters
     * 
     * @return string
     * 
     */
    protected function formatTag()
    {
        if (trim($this->tag) === '') {
            throw new \Exception('Empty tag string');
        }

        return trim(str_replace(['<', '/', '>'], ['', '', ''], $this->tag));
    }

    public function __toString()
    {
        return $this->_build();
    }

}

