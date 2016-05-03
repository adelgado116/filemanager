<?php

  $link_id = mysql_pconnect('localhost', 'root', 'Marine1234');
 
  if (!link_id)
  {
    echo( '<p>Unable to connect to the database server at this time.</p>' );
    exit();
  }

?>