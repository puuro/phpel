rm -r admin
wget https://github.com/puuro/phpel/archive/master.zip
unzip master.zip
rm master.zip
mv phpel-master/* .
rm -r phpel-master
rm admin/files.list
rm admin/files.test
rm admin/include.list
mv admin/modules/update ../update2/
cp -r admin/* ../..
sh ../update2/update2.sh
