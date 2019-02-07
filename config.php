<?php   

if ('RELEASE' == '#{ENVIRONMENT}') {
    return array(
        'mysql_host' => '#{mysql_host}',
        'mysql_username' => '#{mysql_username}',
        'mysql_password' => '#{mysql_password}',
        'mysql_db' => '#{mysql_db}'
    );
} else {
    return include('\config.dev.php');
}
?>