#sudo sed -i 's/include "config.local.php"/include "config.hc.php"/g' ../index.php
cat create.sql | psql -d mrot_shop -U postgres
cat testData.sql | psql -d mrot_shop -U postgres
#cat ../Sql/insertData.sql | psql -d mrot_shop -U postgres
