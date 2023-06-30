<div class="col-12 col-sm-10 mx-auto">
    <h3>Testing MySQLi driver</h3>
{$trim

    {$import driver.MySQLi $}

    {$set mysqli = new driver\MySQLi() $}
    {$mysqli->connect('cloo_admin', 'ClooAdmin@1234', 'cloo'):noreturn $}
    {$set users={$@mysqli->query('SELECT * FROM `cloo`.`user`;')['rows'] $} $}
    {$html.table({$@users$}) $}

$}
</div>
