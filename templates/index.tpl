
{$set_if_null php.get.page = 'home' $}
{* {$set php.cookie.login = true $}  *}
<!DOCTYPE html>
<html>
    {$include 'fragments/head' $}
    <body class="container mx-auto">
        {$include 'fragments/nav' $}
        {$include 'fragments/main' $}
        {$include 'fragments/footer' $}
    </body>
</html>
