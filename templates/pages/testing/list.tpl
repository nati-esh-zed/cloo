<div class="col-12 col-sm-10 mx-auto">
    <h3>Testing List</h3>
{$trim
    {$set names=array(
        'Natnael',
        'Tamru',
        'Saba',
    ) $}
$}
    {$html.list({$@names$}, 'ul', "\t")$}
</div>
