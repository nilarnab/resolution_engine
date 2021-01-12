<?php
    include "./file_controller.php";
    
    write_file('test', 'Hello world');

    echo read_file('test');

?>