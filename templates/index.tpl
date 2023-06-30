{$trim
    {$set_if_null php.get.page = 'home' $}
    {* {$set_if_null php.cookie.login_info = 'admin,Admin@1234' $}  *}
    {$exec
        if(isset({$@php.cookie.login_info$}))
        {
            $tok_i = strpos({$@php.cookie.login_info$}, ',');
            $VAR['login_info']['username'] = substr({$@php.cookie.login_info$}, 0, $tok_i);
            $VAR['login_info']['password'] = substr({$@php.cookie.login_info$}, $tok_i + 1);
        }
    $}
$}
<!DOCTYPE html>
<html>
    {$include 'fragments/head' $}
    <body class="container mx-auto">
        <script>const base_url = {$site.base_url$};</script>
        {$include 'fragments/nav' $}
        {$include 'fragments/main' $}
        {$include 'fragments/footer' $}
    </body>
</html>
