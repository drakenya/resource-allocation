php -S localhost:8000 -t public public/index.php

php vendor/bin/phinx rollback -t 0 && php vendor/bin/phinx migrate && php vendor/bin/phinx seed:run -v