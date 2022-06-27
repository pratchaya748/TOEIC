<?php
$table = "student_data";


// Table's primary key
$primaryKey = 'student_id';
$columns = array(
    array( 'db' => 'student_id', 'dt' => 0 ),
    array( 'db' => 'Order_ID',  'dt' => 1 ),
    array( 'db' => 'CustomerName',   'dt' => 2 ),
    array( 'db' => 'Status',   'dt' => 3 ),
    array( 'db' => 'FirstName',     'dt' => 4 ),
    array( 'db' => 'FirstNamestaff',     'dt' => 5 )
);


// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'toeic',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'DataTables/examples/server_side/scripts/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);