<?php

namespace Rosswilson252\Html;

use Illuminate\Support\Traits\Macroable;
use Rosswilson252\Html\ElementBuilder as elm;

class TableBuilder
{

    use Macroable;

    /**
     * The HTML builder instance
     * 
     * @var \Rosswilson252\Html\HtmlBuilder
     */
    protected $html;

    /**
     * Table header cells
     * 
     * @var \Rosswilson252\Html\ElementBuilder 
     */
    protected $header_row;
    
    /**
     * Table body rows
     * 
     * @var array 
     */
    protected $body_rows = [];

    /**
     * Table Footer cells
     * 
     * @var type 
     */
    protected $footer_row;

    public function __conastruct(HtmlBuilder $html)
    {
        $this->html = $html;
    }

    /**
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    public function header()
    {
        $args = func_get_args();

        $cells = '';
        
        foreach ($args as $arg) {
            
            $cells .= $this->headerCell($arg);
        }
        
        $this->header_row = new elm('tr', false, [], $cells);
        
        return $this->header_row;
    }
   
    /**
     * Add row to table
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    public function row()
    {
        $args = func_get_args();
        
        $cells = '';
        
        foreach ($args as $arg) {
            
            $cells .= $this->cell($arg);
        }
        
        $this->body_rows[] = $row = new elm('tr', false, [], $cells);
        
        return $row;
    }

    /**
     * Add footer row to table
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    public function footer()
    {
        $args = func_get_args();

        $cells = '';
        
        foreach ($args as $arg) {
            
            $cells .= $this->cell($arg);
        }
        
        $this->footer_row = new elm('tr', false, [], $cells);
        
        return $this->footer_row;
    }

    /**
     * Generate the HTML table
     * 
     * @param type $attributes
     * @return \Rosswilson252\Html\ElementBuilder
     */
    public function generate($attributes = [])
    {
        $header = is_null($this->header_row) ? '' : '<thead>'.$this->header_row.'</thead>';
        $body = '<tbody>';
        
        foreach ($this->body_rows as $row) {
            $body .= $row;
        }
        
        $body .= '</tbody>';
        
        $footer = is_null($this->footer_row) ? '' : '<tfoot>'.$this->footer_row.'</tfoot>';
        
        return new elm('table', false, $attributes, $header.$footer.$body);
        
    }

    /**
     * Create a header cell
     * 
     * @param array|string $attributes
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    protected function headerCell($attributes)
    {
        return $this->_cell('th', $attributes);
    }

    /**
     * Create a standard table cell
     * 
     * @param array|string $attributes
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    protected function cell($attributes)
    {
        
        return $this->_cell('td', $attributes);
    }

    /**
     * Create a table cell
     * 
     * @param string       $type cell type
     * @param array|string $attributes
     * 
     * @return \Rosswilson252\Html\ElementBuilder
     */
    protected function _cell($type, $attributes)
    {
        
        if (!is_array($attributes)) {
            return new elm($type, false, [], $attributes);
        }

        $content = array_pull($attributes, 'content');
        
        return new elm($type, false, $attributes, $content);
    }

}

