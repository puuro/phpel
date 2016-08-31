cd modules/update
pwd
wget https://github.com/puuro/phpel/archive/master.zip
echo "@\r\n"
unzip master.zip
pwd
echo "@\r\n"
rm master.zip
pwd
echo "@\r\n"
mv phpel-master/* .
echo "@\r\n"
rm -r phpel-master
echo "@\r\n"
rm admin/files.list
echo "@\r\n"
rm admin/files.test
echo "@\r\n"
rm admin/include.list
echo "@\r\n"
cp -r admin/modules/update ../update2/
echo "@\r\n"
rm -r admin/modules/update2
echo "@\r\n"
rm -r admin/modules/update
echo "@\r\n"
cp -r admin/* ../..
echo "@\r\n"
rm -r admin
echo "@\r\n"
sh ../update2/update2.sh
echo "@\r\n"
