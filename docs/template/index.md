# Template docs

[cloo](../index.md)

## index

- [syntax](syntax.md)
- [keywords](keywords.md)

### Notes

- Arrays and objects are printed in tabbed JSON format using `{$...$}`
- Strings are not quoted with `"..."` if not in arrays or objects.
- Variables and functions declared using `{$set ...$}` are stored in a global associative array named `$VAR`.
- Variable values are returned when using `{$...$}` and variable code is returned when using `{$@...$}`. Use the later to reference in php code blocks. 
- `{$a.b.c$}` -> `$VAR['a']['b']['c']` the initial set of dot operators are translated to associative array access.