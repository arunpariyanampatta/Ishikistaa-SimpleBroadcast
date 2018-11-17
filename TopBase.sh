#!/bin/bash
ANSWER_DATE=$( date -d "-5 days" +'%Y-%m-%d' )
source /var/local/Shell_Script/broadcast_base_auto.conf
backup_time=$(date +%Y%m%d_%H_%M_%S);
table_name="vas_top_base_${backup_time}"
backup_name="vas_top_base_${backup_time}.sql.gz"
echo "Backup Process started at $(date +%Y%m%d_%H_%M_%S)";
cd $BACKUP_PATH
mysqldump -h $HOST -u $USER -p"$PASSWORD" $DB $TABLE2 --extended-insert --max_allowed_packet=512M  --single-transaction --where "date(ANSWER_DATE) >= $ANSWER_DATE and MSISDN in(SELECT MSISDN from tbl_qn_subscribers where DND_STATUS = '0') GROUP BY MSISDN" |\
  sed -e "s/tbl_qn_answers/${table_name}/"| gzip -c >$backup_name
echo "Backup Process finished at $(date +%Y%m%d_%H_%M_%S)";

echo "Restore and validation check process started at $(date +%Y%m%d_%H_%M_%S)";
gunzip < $backup_name | mysql $DEST_DB
echo "Restore and validation check process finished at $(date +%Y%m%d_%H_%M_%S)";