# Template docs

[index](index.md)

## keywords

`{$keyword}`

- [`eval`](#eval)       -- evaluates then returns the `php`+`template` code given. 
- [`exec`](#exec)       -- executes the `php`+`template` code given. 
- [`if`](#if)           -- evaluates the conditions and executes the chosen `php`+`template` code given.
- [`import`](#import)   -- imports a class file located under `class/` using `require_once`.
- [`include`](#include) -- includes a template file.
- [`set`](#set)         -- sets a variable.
- [`(get)`](#(get))     -- gets a variable by default.

### (get)

- To get variables

  `{$varname $}`  
  `{$varname.subvar $}`  
  `{$varname.data.array[0] $}`
  `{$varname.data.array['key'] $}`  
  `{$varname.object->var $}`
  `{$@varname $}`  -- returns the php code `$VAR['varname']` instead of the value. 
  `{$varname:ref$}` -- same as `{$@varname $}`
  `{$varname:default('my var') $}` 

- To call functions and get their return values

  `{$varname() $}`  
  `{$varname.subvar() $}`  
  `{$varname.data.array[0]() $}`
  `{$varname.data.array['key']() $}`  
  `{$varname.object->callable$() $}`

### set

- To define variable values.

  `{$set varname = any-assignable-php-code $}`  
  `{$set varname.subvar = any-assignable-php-code $}`  

- To define functions.

  `{$set funcname = php-function-declaration-code $}`  
  `{$set varname.funcname = php-function-declaration-code $}`  

  Sets a variable to value. All variables declared this way are stored in a global variable named `$VAR`. And can be accessed using the array indexing operator like `$VAR['varname']` and `$VAR['varname']['subvar']` in `php` code using `{$exec $}` or `{$eval $}`, or using the template variable fetch syntax `{$varname$}` and `{$varname.subvar$}`.

### eval

- To evaluate a `php` expression and return the result;

  `{$eval php-expression $}`

### exec

- To evaluate a `php` expression and return the result;

  `{$exec php-code $}`
  `{$exec returning-php-code $}`

### if

- To execute a code block based on conditions.

  `{$if (condition) {true-block} $}`
  `{$if (condition) {true-block} else {false-block} $}`
  `{$if (condition) {true-block} else if(condition2) {2nd-block} else {else-block} $}`

### import

- To import class modules.
  
  `{$import namespace-class $}`
  `{$import 'namespace/class' $}`
  `{$import 'namespace.class':noerror $}`
  `{$import 'namespace.class':onerror <div>import '{$this.class_name$}' failed</div> $}`

### include

- To include template files.
  
  `{$include template-file $}`
  `{$include 'template/file' $}`
  `{$include 'template.file':noerror $}`
  `{$include 'template.file':onerror <div>include '{$this.template_name$}' failed</div> $}`

*previous: [syntax](syntax.md)*
