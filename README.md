# Bestillingsportal for VAF


## Hvordan starte utviklingsserver

1. Opprett fil som heter `config.dev.php` og legg inn følgende i den 
    ```php
    <?php   
    return array(
        'mysql_host' => '<SKRIV SERVERNAVN HER>',
        'mysql_username' => 'tjenestekatalog',
        'mysql_password' => '<SKRIV PASSORD HER>',
        'mysql_db' => 'tjenestekatalog'
    );
    ?>
    ```

2. Start opp lokal werbserver med cmd:
`php.exe -S localhost:3000 -c .` (Hvis php.exe ikke er i path, oppgi full sti til php.exe, feks: `D:\AppData\PHP5.6\php.exe -S localhost:3000 -c .`)