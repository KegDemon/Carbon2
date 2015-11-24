<?php
//************* MUST ALWAYS HAVE THIS ***********//

require('./txtSQL.class.php');

//*************DATABASE SETUP INFO*************//

$db_username	=	'';
$db_password	=	'';
$database		=	'carbon';

//**************PLACE THE DATABASE IS STORED***********//

$sql = new txtSQL('./data/');  

//***********CONNECT TO DATABASE****************//

if(!$sql->db_exists($database)) die ("Please install Database -> <a href='./install.php'>Install DB</a>") ;

$sql->connect($db_username, $db_password) or die ('Unable to Connect To' . $database);

//***********SLECET TO DATABASE****************//

if ( !$sql->selectdb($database) )
{
    print ($database . 'Could not be selected, check to make sure it exists');
}

?>
