<?php

namespace db;

class Table
{
    public $ncolumns = 0, $nrows = 0;
    public $rows = array();
    
    // public function 
    // __construct( $ncolumns_ = 0, $nrows_ = 0, $fill_value_ = null)
    // {
    //     $this->ncolumns = $ncolumns_;
    //     $this->nrows = $nrows_;
    //     $this->rows = array_fill(0, $nrows_, array_fill(0, $ncolumns_, $fill_value_));
    // }

    public function 
    __construct($data)
    {
        if(is_array($data))
        {
            $this->nrows = count($data);
            $this->ncolumns = $this->nrows > 0 ? count($data[0]) : 0;
            $this->rows = $data;
        }
    }

    public function
    html($table_class_ = "table table-striped table-hover p-2")
    {
        $html = "<table class=\"$table_class_\">\n";
        $html .= "\t<thead>\n";
        $header = true;
        foreach($this->rows as $row)
        {
            $tds = $header ? "<th scope=\"col\">" : "<td>";
            $tde = $header ? "</th>" : "</td>";
            $html .= "\t\t<tr>\n";
            foreach($row as $val)
                $html .= "\t\t\t" . $tds . $val . $tde ."\n";
            $html .= "\t\t</tr>\n";
            if($header)
            {
                $html .= "\t</thead>\n";
                $html .= "\t<tbody>\n";
            }
            $header = false;
        }
        $html .= "\t</tbody>\n";
        $html .= "</table>";
        return $html;
    }

};

?>
