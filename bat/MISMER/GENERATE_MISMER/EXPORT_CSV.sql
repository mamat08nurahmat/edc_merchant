use mattools_db;

SELECT 'MID','MERCHANT_DBA_NAME','STATUS_EDC','CITY','ID_NUMBER','MSO','SOURCE_CODE','POS_1','WILAYAH','CHANNEL','TYPE_MID','OPEN_DATE','TAHUN','BULAN','generate_at','update_at' 

UNION ALL 

SELECT MID,MERCHANT_DBA_NAME,STATUS_EDC,CITY,ID_NUMBER,MSO,SOURCE_CODE,POS_1,WILAYAH,CHANNEL,TYPE_MID,OPEN_DATE,TAHUN,BULAN,generate_at,update_at 
INTO OUTFILE 'C:/xampp/htdocs/mattools/MISMER/BSK_TXT/EXPORT_EDC_MISMER0624.csv' 
FIELDS TERMINATED BY ',' FROM edc_detail; 

--mysql -u root mattools_db < C:/xampp/htdocs/mattools/bat/MISMER/GENERATE_MISMER/EXPORT_CSV.sql


-- RUN IN CMD
--mysql -u root mattools_db -e "SELECT 'MID','MERCHANT_DBA_NAME','STATUS_EDC','CITY','ID_NUMBER','MSO','SOURCE_CODE','POS_1','WILAYAH','CHANNEL','TYPE_MID','OPEN_DATE','TAHUN','BULAN','generate_at','update_at' UNION ALL SELECT MID,MERCHANT_DBA_NAME,STATUS_EDC,CITY,ID_NUMBER,MSO,SOURCE_CODE,POS_1,WILAYAH,CHANNEL,TYPE_MID,OPEN_DATE,TAHUN,BULAN,generate_at,update_at INTO OUTFILE 'C:/xampp/htdocs/mattools/MISMER/BSK_TXT/EXPORT_EDC_DETAIL_123.csv' FIELDS TERMINATED BY ',' FROM edc_detail"
