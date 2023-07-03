<div class="col-12 col-sm-10 mx-auto">
    <h3>Testing Table</h3>
{$trim

    {$set table=array(
        array('ID', 'NAME', 'AGE'),
        array('001', 'Natnael', 25),
        array('002', 'Tamru', 27),
        array('003', 'Saba', 26),
    ) $}
$}
    {$html.table({$@table$})$}    
</div>
