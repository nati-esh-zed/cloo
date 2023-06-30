<?php

class App
{
    private $_exiting  = false;

    public  $extension = array();
    public  $dir       = array();
    public  $common_config_file = null;

    public function 
    __construct()
    {
        global $VAR;
        define('cloo_version', '1.2.9');
        define('command_token_start',     '{$');
        define('command_token_end',       '$}');
        define('command_token_start_len', strlen(command_token_start));
        define('command_token_end_len',   strlen(command_token_end));
        define('comment_token_start',     '{*');
        define('comment_token_end',       '*}');
        define('comment_token_start_len', strlen(comment_token_start));
        define('comment_token_end_len',   strlen(comment_token_end));
        define('reference_token',     '@');
        define('reference_token_len', strlen(reference_token));
        define('to_string_tab', "\t");
        // 
        $VAR['cloo']['version'] = cloo_version;
        //
        $VAR['cloo']['extension']['config']   = $this->extension['config']   = '.ini';
        $VAR['cloo']['extension']['class']    = $this->extension['class']    = '.class.php';
        $VAR['cloo']['extension']['template'] = $this->extension['template'] = '.tpl';
        //
        $root_dir = getcwd() . '/';
        $VAR['cloo']['dir']['root']       = $this->dir['root']      = $root_dir;
        $VAR['cloo']['dir']['config']     = $this->dir['config']    = $root_dir . 'config/';
        $VAR['cloo']['dir']['class']      = $this->dir['class']     = $root_dir . 'class/';
        $VAR['cloo']['dir']['templates']  = $this->dir['templates'] = $root_dir . 'templates/';
        //
        $VAR['php'] = array(
            'server'   => $_SERVER,
            'files'    => $_FILES,
            'get'      => $_GET,
            'post'     => $_POST,
            'request'  => $_REQUEST,
            'cookie'   => $_COOKIE,
            'self'     => $_SERVER['PHP_SELF']
        );
        //
        $VAR['space'] = function($count_ = 1) 
        {
            $result = '';
            for($i = 0; $i < $count_; ++$i)
                $result .= ' ';
            return $result;
        };
        $VAR['tab'] = function($count_ = 1) 
        {
            $result = '';
            for($i = 0; $i < $count_; ++$i)
                $result .= "\t";
            return $result;
        };
        $VAR['newline'] = function($count_ = 1) 
        {
            $result = '';
            for($i = 0; $i < $count_; ++$i)
                $result .= "\n";
            return $result;
        };
        $VAR['paren']        = '(';
        $VAR['/paren']       = ')';
        $VAR['parentheses']  = '(';
        $VAR['/parentheses'] = ')';
        $VAR['brace']        = '{';
        $VAR['/brace']       = '}';
        $VAR['bracket']      = '[';
        $VAR['/bracket']     = ']';
        //
        $VAR['list_templates'] = function($parent_ = null)
        {
            $template_dir = $this->dir['templates'];
            $template_ext = $this->extension['template'];
            $template_ext_len = strlen($template_ext);
            $templates = null;
            $dir       = null;
            if($parent_ != null)
                $template_dir .= $parent_ . '/';
            if(($dir = @opendir($template_dir)) !== false)
            {
                $templates      = array();
                $node           = null;
                $template_count = 0;
                while(($node = readdir($dir)) !== false)
                {
                    if($node == '.' || $node == '..')
                        continue;
                    $rpath = $parent_ == null ? $node : ($parent_ . '/' . $node);
                    $path  = $template_dir . $node;
                    if(is_dir($path))
                    {
                        $name  = $node;
                        array_push($templates, array(
                            'rpath' => $rpath,
                            'name'  => $name,
                            'type'  => 'dir'
                        ));
                    }
                    else if(is_file($path))
                    {
                        $name  = substr($node, 0, strlen($node) - strlen($this->extension['template']));
                        $rpath = $parent_ == null ? $name : ($parent_ . '/' . $name);
                        array_push($templates, array(
                            'rpath' => $rpath,
                            'name'  => $name,
                            'type'  => 'file'
                        ));
                    }
                }
                return $templates;
            }
            return null;
        };
        $VAR['list_sub_templates'] = function($parent_ = null, $root_ = null)
        {
            $template_dir = $this->dir['templates'];
            $template_ext = $this->extension['template'];
            $template_ext_len = strlen($template_ext);
            $templates = null;
            $dir       = null;
            if($root_ != null)
                $template_dir .= $root_ . '/';
            if($parent_ != null)
                $template_dir .= $parent_ . '/';
            if(($dir = @opendir($template_dir)) !== false)
            {
                $templates      = array();
                $node           = null;
                $template_count = 0;
                while(($node = readdir($dir)) !== false)
                {
                    if($node == '.' || $node == '..')
                        continue;
                    $rpath = $parent_ == null ? $node : ($parent_ . '/' . $node);
                    $path  = $template_dir . $node;
                    if(is_dir($path))
                    {
                        $name  = $node;
                        array_push($templates, array(
                            'rpath' => $rpath,
                            'name'  => $name,
                            'type'  => 'dir'
                        ));
                    }
                    else if(is_file($path))
                    {
                        $name  = substr($node, 0, strlen($node) - strlen($this->extension['template']));
                        $rpath = $parent_ == null ? $name : ($parent_ . '/' . $name);
                        array_push($templates, array(
                            'rpath' => $rpath,
                            'name'  => $name,
                            'type'  => 'file'
                        ));
                    }
                }
                return $templates;
            }
            return null;
        };
        //
        $VAR['html'] = array(
            'table' => function($rows_, $table_class_ = "table table-striped table-hover p-2")
            {
                $html = "<table class=\"$table_class_\">\n";
                $html .= "\t<thead>\n";
                $header = true;
                foreach($rows_ as $row)
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
            },
            'list' => function($list_, $list_tag_ = 'ul', $tab_ = '', $list_class_ = "p-2", $list_item_class_ = "p-1")
            {
                $html = "$tab_<$list_tag_ class=\"$list_class_\">\n";
                foreach($list_ as $list_item)
                {
                    $html .= "$tab_\t<li class=\"$list_item_class_\">\n";
                    $html .= $list_item;
                    $html .= "</li>\n";
                }
                $html .= "</$list_tag_>";
                return $html;
            }
        );
        //
        $this->common_config_file = 'site' . $this->extension['config'];
        $this->load_config($this->common_config_file, true);
        $this->load_configs();
    }

    public function
    run()
    {
        // load and display index
        global $VAR;
        $index = file_get_contents($this->dir['templates'] . 'index' . $this->extension['template']);
        $index = $this->process_templates($index);
        print($index);
    }

    public function
    load_config($config, $ext = false)
    {
        $file_name = $config;
        if(!$ext) 
            $file_name .= $this->extension['config'];
        else
            $config = substr($config, 0, strlen($config) - strlen($this->extension['config']));
        $file_path  = $this->dir['config'] . $file_name;
        $config     = str_replace('/', '.', $config);
        if(file_exists($file_path))
        {
            $contents = file_get_contents($file_path);
            global $VAR;
            $len = strlen($contents);
            $ch = '\0';
            for($i = 0; $i < $len; ++$i)
            {
                $ch = $contents[$i];
                if($ch == '#')
                {
                    ++$i;
                    // continue until newline or end
                    while($i < ($len - 1) && ($ch = $contents[$i]) != "\n")
                        ++$i;
                }
                else
                {
                    $j = $i;
                    // continue until newline or end
                    while($i < $len && ($ch = $contents[$i]) != "\n")
                        ++$i;
                    $line_len = ($i - $j + 1);
                    $line  = substr($contents, $j, $line_len);
                    $k     = strpos($line, '=');
                    $key   = trim(substr($line, 0, $k), " \n\t\v");
                    if($key == '')
                        continue;
                    $value = $this->process_templates($line, $k + 1, $line_len);
                    // set config var
                    $key  = $config . '.' . $key;
                    $code = '';
                    if(str_contains($key, '.'))
                    {
                        $ids      = explode('.', $key);
                        $code     = '$VAR';
                        $id_count = count($ids);
                        for($k = 0; $k < $id_count; ++$k)
                        {
                            $id = $ids[$k];
                            $code .= '[\'' . $id . '\']';
                        }
                        $code .= ' = ' . $value . ';';
                    }
                    else
                    {
                        $code = '$VAR[\'' . $key . '\'] = ' . $value . ';';
                    }
                    eval($code);
                }
            }
            return 0;
        }
        return -1;
    }

    public function
    load_configs($subdir = null)
    {
        $config_dir = $this->dir['config'];
        $config_ext = $this->extension['config'];
        $config_ext_len = strlen($config_ext);
        $dir = null;
        if($subdir != null)
            $config_dir .= $subdir . '/';
        if(($dir = @opendir($config_dir)) !== false)
        {
            $node         = null;
            $config_count = 0;
            while(($node = readdir($dir)) !== false)
            {
                if($node == '.' || $node == '..' 
                    || ($subdir == null && $node == $this->common_config_file))
                    continue;
                $rpath = $subdir == null ? $node : ($subdir . '/' . $node);
                $path  = $config_dir . $node;
                if(is_dir($path))
                {
                    $this->load_configs($rpath);
                }
                else if(is_file($path))
                {
                    $offset = strlen($rpath) - $config_ext_len;
                    if(substr_compare($rpath, $config_ext, $offset, $config_ext_len) == 0)
                    {
                        $this->load_config($rpath, true);
                        ++$config_count;
                    }
                }
            }
            return $config_count;
        }
        return -1;
    }

    public function 
    process_templates($string, $start = 0, $end = null, $matching = false)
    {
        if($this->_exiting)
            return '';
        global $VAR;
        $new_string = '';
        if($end == null)
            $end = strlen($string);
        if($start >= $end)
            return '';
        $len = $end - $start;
        $j = 0;
        $checkpoint  = null;
        $open_braces = 0;
        for($i = $start; $i < $end; ++$i)
        {
            if($open_braces > 0 && substr_compare($string, command_token_end, $i, command_token_end_len) == 0)
            {
                $open_braces--;
                if($open_braces == 0 && $checkpoint != null)
                {
                    // process command
                    $command_len = $i - $checkpoint;
                    // echo "(".substr($string, $checkpoint, $command_len).")\n";
                    // set
                    if($command_len >= 3 && substr_compare($string, 'set', $checkpoint, 3) == 0
                        && ($command_len > 3 ? $this->_is_space($string[$checkpoint + 3]) : true))
                    {
                        $start_i = $checkpoint + 4;
                        if($start_i < $i)
                        {
                            $eq_token_pos = strpos($string, '=', $start_i);
                            if($eq_token_pos !== false)
                            {
                                $value_idx = $eq_token_pos + 1;
                                $var_id    = trim(substr($string, $start_i, $eq_token_pos - $start_i), " \n\t\v");
                                $var_value = $this->process_templates($string, $value_idx, $i);
                                $code      = '';
                                if(str_contains($var_id, '.'))
                                {
                                    $ids      = explode('.', $var_id);
                                    $var_code = '$VAR[\'' . $ids[0] . '\']';
                                    for($k = 1; $k < count($ids); ++$k)
                                        $var_code .= '[\'' . $ids[$k] . '\']';
                                    $code  = $var_code . ' = ' . $var_value . ';'; 
                                }
                                else
                                {
                                    $var_code  = '$VAR[\'' . $var_id . '\']';
                                }
                                $code  = $var_code . ' = ' . $var_value . ';'; 
                                eval($code);
                            }
                        }
                    }
                    // set_if_not_set
                    else if($command_len >= 14 && substr_compare($string, 'set_if_not_set', $checkpoint, 14) == 0
                        && ($command_len > 14 ? $this->_is_space($string[$checkpoint + 14]) : true))
                    {
                        $start_i = $checkpoint + 15;
                        if($start_i < $i)
                        {
                            $eq_token_pos = strpos($string, '=', $start_i);
                            if($eq_token_pos !== false)
                            {
                                $value_idx = $eq_token_pos + 1;
                                $var_id    = trim(substr($string, $start_i, $eq_token_pos - $start_i), " \n\t\v");
                                $var_value = $this->process_templates($string, $value_idx, $i);
                                $var_code  = '';
                                if(str_contains($var_id, '.'))
                                {
                                    $ids      = explode('.', $var_id);
                                    $var_code = '$VAR[\'' . $ids[0] . '\']';
                                    for($k = 1; $k < count($ids); ++$k)
                                        $var_code .= '[\'' . $ids[$k] . '\']';
                                }
                                else
                                {
                                    $var_code  = '$VAR[\'' . $var_id . '\']';
                                }
                                $code  = 'if(!isset(' . $var_code . '))' . $var_code . ' = ' . $var_value . ';'; 
                                eval($code);
                            }
                        }
                    }
                    // set_if_null
                    else if($command_len >= 11 && substr_compare($string, 'set_if_null', $checkpoint, 11) == 0
                        && ($command_len > 11 ? $this->_is_space($string[$checkpoint + 11]) : true))
                    {
                        $start_i = $checkpoint + 12;
                        if($start_i < $i)
                        {
                            $eq_token_pos = strpos($string, '=', $start_i);
                            if($eq_token_pos !== false)
                            {
                                $value_idx = $eq_token_pos + 1;
                                $var_id    = trim(substr($string, $start_i, $eq_token_pos - $start_i), " \n\t\v");
                                $var_value = $this->process_templates($string, $value_idx, $i);
                                $var_code  = '';
                                if(str_contains($var_id, '.'))
                                {
                                    $ids      = explode('.', $var_id);
                                    $var_code = '$VAR[\'' . $ids[0] . '\']';
                                    for($k = 1; $k < count($ids); ++$k)
                                        $var_code .= '[\'' . $ids[$k] . '\']';
                                }
                                else
                                {
                                    $var_code  = '$VAR[\'' . $var_id . '\']';
                                }
                                $code  = 'if(!isset(' . $var_code. ') || ' . $var_code . ' === null)' . $var_code . ' = ' . $var_value . ';'; 
                                // echo "$code\n";
                                eval($code);
                            }
                        }
                    }
                    // include
                    else if($command_len >= 7 && substr_compare($string, 'include', $checkpoint, 7) == 0
                        && ($command_len > 7 ? $this->_is_space($string[$checkpoint + 7]) : true))
                    {
                        $start_i = $checkpoint + 8;
                        if($start_i < $i)
                        {
                            $template_name = '';
                            $params_len    = $i - $start_i;
                            $params        = substr($string, $start_i, $params_len);
                            $flag_i        = $this->_token_pos($params, ':', 0, $params_len);
                            $flag          = '';
                            if($flag_i !== false)
                            {
                                $template_name = $this->process_templates($params, 0, $flag_i);
                                $flag          = substr($params, $flag_i + 1);
                                $flag          = trim($flag, " \n\t\v");
                            }
                            else
                            {
                                $template_name = $this->process_templates($params, 0, $params_len);
                            }
                            $template_name = trim($template_name, " \n\t\v'\"");
                            $file_name     = str_replace('.', '/', $template_name) . $this->extension['template'];
                            $file_path     = $this->dir['templates'] . $file_name;
                            $result        = null;
                            // echo "$template_name|$file_name\n";
                            if(file_exists($file_path))
                            {
                                $contents = file_get_contents($file_path);
                                $result   = $this->process_templates($contents);
                            }
                            if($flag_i !== false)
                            {
                                if(substr_compare($flag, 'noerror', 0, 7) == 0)
                                {
                                    if($result === null)
                                        $result = '';
                                }
                                else if(substr_compare($flag, 'onerror', 0, 7) == 0)
                                {
                                    if($result === null)
                                    {
                                        $VAR['this'] = array('template_name' => $template_name);
                                        $result      = $this->process_templates($flag, 8);
                                        $VAR['this'] = null;
                                    }
                                }
                            }
                            if($result === null)
                            {
                                $result = "<div class=\"alert alert-danger\"><strong>Error (include):</strong> Template '$template_name' not found!</div>";
                            }
                            $new_string .= $result;
                            $j += strlen($result);
                        }
                    }
                    // import
                    else if($command_len >= 6 && substr_compare($string, 'import', $checkpoint, 6) == 0
                        && ($command_len > 6 ? $this->_is_space($string[$checkpoint + 6]) : true))
                    {
                        $start_i = $checkpoint + 7;
                        if($start_i < $i)
                        {
                            $class_name = '';
                            $params_len = $i - $start_i;
                            $params     = substr($string, $start_i, $params_len);
                            $flag_i     = $this->_token_pos($params, ':', 0, $params_len);
                            $flag       = '';
                            if($flag_i !== false)
                            {
                                $class_name = $this->process_templates($params, 0, $flag_i);
                                $flag       = substr($params, $flag_i + 1);
                                $flag       = trim($flag, " \n\t\v");
                            }
                            else
                            {
                                $class_name = $this->process_templates($params, 0, $params_len);
                            }
                            $class_name = trim($class_name, " \n\t\v'\"");
                            $file_name  = str_replace('.', '/', $class_name) . $this->extension['class'];
                            $file_path  = $this->dir['class'] . $file_name;
                            $result     = false;
                            if(file_exists($file_path))
                            {
                                require_once($file_path);
                                $result = '';
                            }
                            if($flag_i !== false)
                            {
                                if(substr_compare($flag, 'retbool', 0, 7) == 0)
                                {
                                    $result = $result ? 'true' : 'false';
                                }
                                else if(substr_compare($flag, 'retint', 0, 6) == 0)
                                {
                                    $result = $result ? '1' : '0';
                                }
                                else if(substr_compare($flag, 'noerror', 0, 7) == 0)
                                {
                                    if($result === false)
                                        $result = '';
                                }
                                else if(substr_compare($flag, 'onerror', 0, 7) == 0)
                                {
                                    if($result === false)
                                    {
                                        $VAR['this'] = array('class_name' => $class_name);
                                        $result      = $this->process_templates($flag, 8);
                                        $VAR['this'] = null;
                                    }
                                    else
                                        $result = '';
                                }
                            }
                            if($result === false)
                            {
                                $result = "<div class=\"alert alert-danger\"><strong>Error (import):</strong> Class '$class_name' not found!</div>";
                            }
                            $new_string .= $result;
                            $j += strlen($result);
                        }
                    }
                    // eval
                    else if($command_len >= 4 && substr_compare($string, 'eval', $checkpoint, 4) == 0
                        && ($command_len > 4 ? $this->_is_space($string[$checkpoint + 4]) : true))
                    {
                        $start_i = $checkpoint + 5;
                        if($start_i < $i)
                        {
                            $rcode       = $this->process_templates($string, $start_i, $i);
                            // echo "$rcode\n";
                            $code        = '{ return ' . $rcode . '; }';
                            $result      = eval($code);
                            $new_string .= $result;
                            $j += strlen($result);
                        }
                    }
                    // exec
                    else if($command_len >= 4 && substr_compare($string, 'exec', $checkpoint, 4) == 0
                        && ($command_len > 4 ? $this->_is_space($string[$checkpoint + 4]) : true))
                    {
                        $start_i = $checkpoint + 5;
                        if($start_i < $i)
                        {
                            $rcode   = $this->process_templates($string, $start_i, $i);
                            $code    = '{' . $rcode . '; return null; }';
                            // echo "$code\n";
                            $result  = eval($code);
                            if($result !== null)
                            {
                                $new_string .= $result;
                                $j += strlen($result);
                            }
                        }
                    }
                    // trim
                    else if($command_len >= 4 && substr_compare($string, 'trim', $checkpoint, 4) == 0
                        && ($command_len > 4 ? $this->_is_space($string[$checkpoint + 4]) : true))
                    {
                        $start_i = $checkpoint + 5;
                        if($start_i < $i)
                        {
                            $result  = $this->process_templates($string, $start_i, $i);
                            $result  = trim($result);
                            if($result !== null)
                            {
                                $new_string .= $result;
                                $j += strlen($result);
                            }
                        }
                    }
                    // exit
                    else if($command_len >= 4 && substr_compare($string, 'exit', $checkpoint, 4) == 0 
                        && ($command_len > 4 ? $this->_is_space($string[$checkpoint + 4]) : true))
                    {
                        $this->_exiting = true;
                        return $new_string;
                    }
                    // if
                    else if($command_len >= 2 && substr_compare($string, 'if', $checkpoint, 2) == 0 
                        && ($command_len > 2 
                            ? ($this->_is_space($string[$checkpoint + 2]) || $string[$checkpoint + 2] == '(') 
                            : true))
                    {
                        $start_i = $checkpoint + ($string[$checkpoint + 2] == '(' ? 2 : 3);
                        if($start_i < $i)
                        {
                            $end_i               = $i;
                            $processing_if       = true;
                            $expecting_condition = true;
                            $cur_i               = $start_i;
                            $rcondition          = false;
                            while(!$rcondition && $cur_i < $end_i)
                            {
                                if($processing_if)
                                {
                                    $processing_if = false;
                                }
                                else
                                {
                                    // skip spaces
                                    for(; $cur_i < $end_i; ++$cur_i)
                                    {
                                        $ch = $string[$cur_i];
                                        if(!($this->_is_space($ch)))
                                            break;
                                    }
                                    // check for 'else [if]' keyword
                                    $len_left = $end_i - $cur_i;
                                    if($len_left >= 7 && substr_compare($string, 'else if', $cur_i, 7) == 0
                                        && ($len_left > 7 
                                            ? ($string[$cur_i + 7] == '(' || $this->_is_space($string[$cur_i + 7]))
                                            : true)
                                    )
                                    {
                                        // echo "{{else if}}\n";
                                        $cur_i += $string[$cur_i] == '(' ? 7 : 8;
                                        $expecting_condition = true;
                                    }
                                    else if($len_left >= 4 && substr_compare($string, 'else', $cur_i, 4) == 0
                                        && ($len_left > 4 
                                            ? ($string[$cur_i + 4] == '(' || $this->_is_space($string[$cur_i + 4]))
                                            : true))
                                    {
                                        // echo "{{else}}\n";
                                        $cur_i += $string[$cur_i] == '{' ? 4 : 5;
                                        $expecting_condition = false;
                                        $rcondition          = true;
                                    }
                                }
                                if(!$rcondition && $expecting_condition)
                                {
                                    $condition_start_i = $cur_i;
                                    $condition_end_i   = $cur_i;
                                    $open_parenthesis  = 0;
                                    $enclosed          = false;
                                    for(; $cur_i < $end_i; ++$cur_i)
                                    {
                                        $ch = $string[$cur_i];
                                        if($ch == '(')
                                        {
                                            if($open_parenthesis == 0)
                                                $condition_start_i = $cur_i;
                                            $open_parenthesis++;
                                            $enclosed = true;
                                        }
                                        else if($ch == ')')
                                        {
                                            $open_parenthesis--;
                                        }
                                        else if($open_parenthesis <= 0)
                                        {
                                            if($this->_is_space($ch))
                                            {
                                                $condition_end_i = $cur_i;
                                                break;
                                            }
                                            else if($enclosed)
                                            {
                                                $condition_end_i = $cur_i - 1;
                                                break;
                                            }
                                        }
                                    }
                                    $condition  = $this->process_templates($string, $condition_start_i, $condition_end_i);
                                    $condition  = trim($condition, " \n\t\v");
                                    // echo "[$condition] \{" . substr($string, $condition_end_i + 1, $end_i - $condition_end_i) . "\}\n";
                                    $rcondition = ($condition == null || $condition == '')
                                        ? false
                                        : eval('return ' . $condition . ';');
                                }
                                // find block indices and process it
                                {
                                    $block_start_i = $cur_i + 1;
                                    $block_end_i   = $end_i;
                                    // find block indices
                                    {
                                        $open_block_tokens = 0;
                                        for($cur_i = $block_start_i; $cur_i < $end_i; ++$cur_i)
                                        {
                                            $ch = $string[$cur_i];
                                            if($ch == '{')
                                            {
                                                if($open_block_tokens == 0)
                                                    $block_start_i = $cur_i + 1;
                                                $open_block_tokens++;
                                            }
                                            else if($ch == '}')
                                            {
                                                $open_block_tokens--;
                                                if($open_block_tokens <= 0)
                                                {
                                                    $block_end_i = $cur_i;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    // echo "[$condition:$rcondition] \{" . substr($string, $block_start_i, $block_end_i - $block_start_i) . "\}\n";
                                    if($rcondition)
                                    {
                                        // echo "[$condition:$rcondition] \{" . substr($string, $block_start_i, $block_end_i - $block_start_i) . "\}\n";
                                        $result      = $this->process_templates($string, $block_start_i, $block_end_i);
                                        $new_string .= $result;
                                        $j += strlen($result);
                                        break;
                                    }
                                    else
                                    {
                                        $cur_i = $block_end_i + 1;
                                    }
                                }
                            }
                        }
                    }
                    // foreach
                    else if($command_len >= 7 && substr_compare($string, 'foreach', $checkpoint, 7) == 0 
                        && ($command_len > 7 
                            ? ($this->_is_space($string[$checkpoint + 7]) || $string[$checkpoint + 7] == '(') 
                            : true))
                    {
                        $start_i = $checkpoint + ($string[$checkpoint + 7] == '(' ? 7 : 8);
                        if($start_i < $i)
                        {
                            $end_i               = $i;
                            $cur_i               = $start_i;
                            $done                = false;
                            while(!$done && $cur_i < $end_i)
                            {
                                {
                                    $foreach_code_start_i = $cur_i;
                                    $foreach_code_end_i   = $cur_i;
                                    $open_parenthesis     = 0;
                                    $enclosed             = false;
                                    for(; $cur_i < $end_i; ++$cur_i)
                                    {
                                        $ch = $string[$cur_i];
                                        if($ch == '(')
                                        {
                                            if($open_parenthesis == 0)
                                                $foreach_code_start_i = $cur_i;
                                            $open_parenthesis++;
                                            $enclosed = true;
                                        }
                                        else if($ch == ')')
                                        {
                                            $open_parenthesis--;
                                        }
                                        else if($open_parenthesis <= 0)
                                        {
                                            if($this->_is_space($ch))
                                            {
                                                $foreach_code_end_i = $cur_i;
                                                break;
                                            }
                                            else if($enclosed)
                                            {
                                                $foreach_code_end_i = $cur_i - 1;
                                                break;
                                            }
                                        }
                                    }
                                    $foreach_code  = $this->process_templates($string, $foreach_code_start_i, $foreach_code_end_i);
                                    $foreach_code  = trim($foreach_code, " \n\t\v");
                                    // echo "[$foreach_code] \{" . substr($string, $foreach_code_end_i + 1, $end_i - $foreach_code_end_i) . "\}\n";
                                    // find block indices and process it
                                    {
                                        $block_start_i = $cur_i + 1;
                                        $block_end_i   = $end_i;
                                        // find block indices
                                        {
                                            $open_block_tokens = 0;
                                            for($cur_i = $block_start_i; $cur_i < $end_i; ++$cur_i)
                                            {
                                                $ch = $string[$cur_i];
                                                if($ch == '}')
                                                {
                                                    $open_block_tokens--;
                                                    if($open_block_tokens <= 0)
                                                    {
                                                        $block_end_i = $cur_i;
                                                        break;
                                                    }
                                                }
                                                else if($ch == '{')
                                                {
                                                    if($open_block_tokens == 0)
                                                        $block_start_i = $cur_i + 1;
                                                    $open_block_tokens++;
                                                }
                                                else if($open_block_tokens <= 0 && !$this->_is_space($ch))
                                                {
                                                    break;
                                                }
                                            }
                                        }
                                        $cur_i = $block_end_i + 1;
                                        // if($rcondition)
                                        {
                                            // echo "[$foreach_code] \{" . substr($string, $block_start_i, $block_end_i - $block_start_i) . "\}\n";
                                            $keyword_as_i     = strpos($foreach_code, ' as ');
                                            $iter_var_start_i = $keyword_as_i + 4;
                                            $iter_var_end_i   = strrpos($foreach_code, ')') - 1;
                                            $iter_var = trim(substr($foreach_code, $iter_var_start_i, $iter_var_end_i - $iter_var_start_i + 1));
                                            // echo "[$iter_var]\n";
                                            $tmp_var = null;
                                            if(isset($VAR[$iter_var]))
                                                $tmp_var = $VAR[$iter_var];
                                            $loop_var_code = substr($foreach_code, 1, $keyword_as_i);
                                            // echo "$loop_var_code\n";
                                            $loop_var      = eval('return ' . $loop_var_code . ';');
                                            // echo "{" . substr($string, $block_start_i, $block_end_i - $block_start_i) . "}\n";
                                            foreach($loop_var as $_cloo_internal_loop_elem)
                                            {
                                                $VAR[$iter_var] = $_cloo_internal_loop_elem;
                                                $result         = $this->process_templates($string, $block_start_i, $block_end_i);
                                                $new_string    .= $result;
                                                $j += strlen($result);
                                            }
                                            if($tmp_var !== null)
                                                $VAR[$iter_var] = $tmp_var;
                                            break;
                                        }
                                    }
                                }
                                $done = true;
                            }
                        }
                    }
                    else if($command_len > 0 && $this->_is_space($string[$checkpoint]))
                    {
                        $error       = "<div class=\"alert alert-danger\"><strong>Syntax Error:</strong> Space after `" . '{$' . "`! Expecting valid id.</div>";
                        $new_string .= $error;
                        $j          += strlen($error);
                        // return $new_string;
                    }
                    // parse variable value
                    else if($command_len > 0)
                    {
                        $start_i    = $checkpoint;
                        $end_i      = $i;
                        $reference  = substr_compare($string, reference_token, $start_i, reference_token_len) == 0;
                        $noreturn   = false;
                        if($reference)
                            $start_i += reference_token_len;
                        $parameter_token_pos     = $this->_token_pos($string, ':', $start_i, $end_i);
                        $member_access_token_pos = $this->_token_pos($string, '->', $start_i, $end_i);
                        $array_access_token_pos  = $this->_token_pos($string, '[', $start_i, $end_i);
                        $function_call_token_pos = $this->_token_pos($string, '(', $start_i, $end_i);
                        $default_value = null;
                        if($parameter_token_pos === false)
                            $parameter_token_pos = $end_i;
                        if($member_access_token_pos === false)
                            $member_access_token_pos = $end_i;
                        if($array_access_token_pos === false)
                            $array_access_token_pos = $end_i;
                        if($function_call_token_pos === false)
                            $function_call_token_pos = $end_i;
                        $var_id_end_i = min(array(
                            $parameter_token_pos,
                            $member_access_token_pos,
                            $array_access_token_pos,
                            $function_call_token_pos
                        ));
                        $ext_id_end_i = min(
                            $parameter_token_pos, 
                            $function_call_token_pos
                        );
                        $calling_a_function = $function_call_token_pos < $end_i;
                        $var_id    = substr($string, $start_i, $var_id_end_i - $start_i);
                        $var_id    = trim($var_id);
                        $ext_id    = $var_id_end_i == $end_i
                            ? null
                            : substr($string, $var_id_end_i, $ext_id_end_i - $var_id_end_i);
                        $ext_id    = trim($ext_id);
                        $params    = $parameter_token_pos == $end_i
                            ? null
                            : substr($string, $parameter_token_pos + 1, $end_i - $parameter_token_pos - 1);
                        $var_value = null;
                        $var_code  = '';
                        $ext_code  = '';
                        if(strpos($var_id, '.') !== false)
                        {
                            $ids      = explode('.', $var_id);
                            $var_code = '$VAR[\'' . $ids[0] . '\']';
                            for($k = 1; $k < count($ids); ++$k)
                                $var_code .= '[\'' . $ids[$k] . '\']';
                            $ext_code = $var_code;
                            if($ext_id != null)
                            {
                                if(!($calling_a_function || $var_id_end_i == $parameter_token_pos))
                                    $var_code .= $ext_id;
                                $ext_code .= $ext_id;
                            }
                        }
                        else
                        {
                            $var_code  = '$VAR[\'' . $var_id . '\']';
                            $ext_code = $var_code;
                            if($ext_id != null)
                            {
                                if(!($calling_a_function || $var_id_end_i == $parameter_token_pos))
                                    $var_code .= $ext_id;
                                $ext_code .= $ext_id;
                            }
                        }
                        // echo "$var_code|$ext_id|$params\n";
                        // echo "$ext_code|$params\n";
                        // process parameters
                        for($cur_i = $parameter_token_pos; $cur_i < $end_i; ++$cur_i)
                        {
                            if(substr_compare($string, 'default{', $cur_i, 8) == 0)
                            {
                                if($var_value == null)
                                {
                                    $cur_i        += 7;
                                    $block_start_i = $cur_i;
                                    $block_end_i   = $end_i;
                                    // find block indices
                                    {
                                        $open_block_tokens = 0;
                                        for($cur_i = $block_start_i; $cur_i < $end_i; ++$cur_i)
                                        {
                                            $ch = $string[$cur_i];
                                            if($ch == '{')
                                            {
                                                if($open_block_tokens == 0)
                                                    $block_start_i = $cur_i + 1;
                                                $open_block_tokens++;
                                            }
                                            else if($ch == '}')
                                            {
                                                $open_block_tokens--;
                                                if($open_block_tokens <= 0)
                                                {
                                                    $block_end_i = $cur_i;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    $default_value = $this->process_templates($string, $block_start_i, $block_end_i);
                                    // echo "$default_value\n";
                                    $cur_i     = $block_end_i;
                                }
                            }
                            else if(substr_compare($string, 'ref', $cur_i, 3) == 0)
                            {
                                $reference = true;
                                $cur_i += 3;
                            }
                            else if(substr_compare($string, 'noreturn', $cur_i, 8) == 0)
                            {
                                $noreturn = true;
                                $cur_i += 8;
                            }
                        }
                        if($calling_a_function)
                        {
                            $function_args = $this->process_templates($string, $function_call_token_pos, $parameter_token_pos);
                            if($reference)
                            {
                                $code  = $ext_code . $function_args;
                                // echo "$code\n";
                                $var_value = $code;
                            }
                            else
                            {
                                $code  = 'return isset(' . $var_code . ') ? (' . $ext_code . $function_args . ') : null;'; 
                                // echo "$code\n";
                                $var_value = eval($code);
                            }
                        }
                        else if($reference)
                        {
                            // echo "$var_code\n";
                            $var_value = $ext_code; 
                        }
                        else
                        {
                            $code      = 'return isset(' . $var_code . ') ? (' . $ext_code . ') : null;'; 
                            $var_value = eval($code);
                        }
                        // process variable value
                        if(!($reference || is_string($var_value)))
                        {
                            if($var_value === null)
                            {
                                if($default_value !== null)
                                    $var_value = $default_value;
                                else
                                    $var_value = 'null';
                            }
                            else if(is_bool($var_value))
                                $var_value = $var_value ? 'true' : 'false';
                            else if(is_array($var_value))
                            {
                                $var_value = $this->_var_to_string($var_value);
                            }
                            else if(is_object($var_value))
                            {
                                $var_value = $this->_var_to_string($var_value);
                            }
                            else if(is_callable($var_value))
                            {
                                $result = $var_value();
                                $var_value = $result === null ? 'null' : $result;
                            }
                        }
                        if(!$noreturn)
                        {
                            $new_string .= $var_value;
                            $j += strlen($var_value);
                        }
                    }
                    $checkpoint = null;
                }
                $i += command_token_end_len - 1;
            }
            else if(substr_compare($string, command_token_start, $i, command_token_start_len) == 0)
            {
                if($open_braces == 0)
                    $checkpoint = $i + command_token_start_len;
                $open_braces++;
                $i += command_token_start_len - 1;
            }
            else if(substr_compare($string, comment_token_start, $i, comment_token_start_len) == 0)
            {
                for($i += comment_token_start_len; $i < $end; ++$i)
                {
                    if(substr_compare($string, comment_token_end, $i, comment_token_end_len) == 0)
                    {
                        $i += comment_token_end_len - 1;
                        break;
                    }
                }
            }
            else if($open_braces <= 0)
            {
                $new_string[$j++] = $string[$i];
            }
        }
        return $new_string;
    }

    private function
    _is_space($ch)
    {
        return ($ch == " " || $ch == "\t" || $ch == "\n" || $ch == "\v");
    }

    private function
    _var_to_string($var, $default_value = null, $quote_string_ = false, $tab_ = '', $skip_tab_ = false)
    {
        $tab       = $tab_ === null ? '' : $tab_;
        $str_value = $skip_tab_ ? '' : $tab_;
        if($var === null)
        {
            if($default_value !== null)
                $str_value .= $default_value;
            else
                $str_value .= 'null';
        }
        else if(is_string($var))
            $str_value .= $quote_string_ ? "\"$var\"" : $var;
        else if(is_bool($var))
            $str_value .= $var ? 'true' : 'false';
        else if(is_array($var))
        {
            $array       = $var;
            $array_keys  = array_keys($array);
            $count       = count($array_keys);
            if($count > 0)
            {
                $associative_array = is_string($array_keys[0]);
                $count_1     = $count - 1;
                $str_value  .= $associative_array ? "{\n" : "[\n";
                $next_tab_   = $tab_ . to_string_tab;
                for($l = 0; $l < $count; ++$l)
                {
                    // $str_value .= $tab_;
                    if($associative_array)
                    {
                        $key   = $array_keys[$l];
                        $value = $array[$key];
                        $str_value .= $next_tab_ . "\"$key\"" . ": " . $this->_var_to_string($value, null, true, $next_tab_, true);
                    }
                    else
                    {
                        $value = $array[$l];
                        $str_value .= $this->_var_to_string($value, null, true, $next_tab_);
                    }
                    if($l < $count_1)
                        $str_value .= ", \n";
                }
                $str_value .= "\n" . $tab_ . ($associative_array ? "}" : "]");
            }
            else 
            {
                $str_value .= "[]";
            }
        }
        else if(is_object($var))
        {
            $object      = $var;
            $object_vars = get_object_vars($object);
            $var_keys    = array_keys($object_vars);
            $count       = count($var_keys);
            if($count > 0)
            {
                $count_1     = $count - 1;
                $str_value  .= "{\n";
                $next_tab_   = $tab_ . to_string_tab;
                for($l = 0; $l < $count; ++$l)
                {
                    $key = $var_keys[$l];
                    $str_value .= $next_tab_. "\"$key\"" . ": " . $this->_var_to_string($object_vars[$key], null, true, $next_tab_, true);
                    if($l < $count_1)
                        $str_value .= ", \n";
                }
                $str_value .= "\n" . $tab_ . "}";
            }
            else 
            {
                $str_value .= "{}";
            }
        }
        else if(is_callable($var))
        {
            $result = $var();
            $str_value .= $result === null ? 'null' : $this->_var_to_string($result, $default_value, $quote_string_, $tab_, $skip_tab_);
        }
        else
            $str_value .= $var;
        return $str_value;
    }

    private function
    _token_pos($string, $token, $start_i = 0, $end_i = null)
    {
        $token_len     = strlen($token);
        $end_i         = ($end_i === null ? strlen($string) : $end_i) - $token_len;
        $open_commands = 0;
        for($i = $start_i; $i < $end_i; ++$i)
        {
            if(substr_compare($string, command_token_end, $i, command_token_end_len) == 0)
            {
                if($open_commands > 0)
                    $open_commands--;
                $i += command_token_end_len - 1;
            }
            else if(substr_compare($string, command_token_start, $i, command_token_start_len) == 0)
            {
                $open_commands++;
                $i += command_token_start_len - 1;
            }
            else if(substr_compare($string, $token, $i, $token_len) == 0)
            {
                if($open_commands <= 0)
                    return $i;
            }
        }
        return false;
    }

    private function
    _string_pos($string, $token, $start, $end)
    {
        $token_len = strlen($token);
        $end -= $token_len;
        for($i = $start; $i < $end; ++$i)
        {
            if(substr_compare($string, $token, $i, $token_len) == 0)
                return $i;
        }
        return false;
    }

}

?>