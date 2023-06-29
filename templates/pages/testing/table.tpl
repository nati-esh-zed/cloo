<div class="col-12 col-sm-10 mx-auto">
    <h3>testing table</h3>

    {$import db.Table $}

    {$set data=new db\Table(array(
        array('ID', 'NAME', 'AGE'),
        array('001', 'Natnael', 25),
        array('002', 'Tamru', 27),
        array('003', 'Saba', 26),
    )) $}

    {$data->html() $}
    {* {$html.table({$@data->rows$})$} *}
    
</div>
