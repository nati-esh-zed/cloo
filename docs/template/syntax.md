# Template docs

[index](index.md)

## syntax

Basic syntax looks like `{$command params...$}`. Command must start with `{$command` and end with `$}`. *No token escape is provided as of now.*  

### getting variables

To get a variable: use `{$var_id$}`.

examples: `{$my_var$}`, `{$foo.bar$}`, `{$foo->bar$}`, `{$array['key']$}`

### calling functions

To call a function: use `{$function_var_id(params...)$}`.


*next: [keywords](keywords.md)*