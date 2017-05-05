#!/bin/bash
#######################################
# HSS_DB BACKUP ROUTINE
# ADE for HSS
# 2015.01.30
#######################################

# get date/time
DATE=$(date +%Y%m%d_%H%M)

# define filenames
FILENAME=hss_db.sql
BACKUPFILENAME=dbbackup-$DATE.tar

# execute backup
mysqldump -u root -pMarine1234 hss_db > $FILENAME

# compress database file
tar -cvf $BACKUPFILENAME $FILENAME > /dev/null

# remove SQL file
rm $FILENAME
# move backup file to NFS server
mv $BACKUPFILENAME /mnt/knowledgebase/hss_db_backup/$BACKUPFILENAME


# restore
#mysql -u root -pMarine1234 hss_db < /home/hssadmin/hss_db_[datetime].sql
