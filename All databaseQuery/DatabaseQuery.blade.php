{{-- * --}}






SELECT *
FROM timesheetusers
WHERE createdby = 819
AND date BETWEEN '2023-11-13' AND '2023-11-18';
{{-- * --}}
SELECT
partner,
SUM(hour) as total_hours,
COUNT(DISTINCT timesheetid) as row_count
FROM
timesheetusers
WHERE
createdby = (SELECT teammember_id FROM users WHERE id = 819)
AND date BETWEEN 13-11-2023 AND 18-11-2023
GROUP BY
partner;

{{-- * select table heading like id,name,city etc --}}

//change hare only table name

SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'notifications';


{{-- *serach key in phpmyadmin --}}
create table `timesheetuser
INSERT INTO `timesheetusers
{{-- * database error --}}
TRUNCATE TABLE timesheetusers;
DROP TABLE timesheetusers;
{{-- * database error --}}
performanceevaluationforms
{{-- * count in database --}}
SELECT COUNT(*) as count FROM `assignmentbudgetings` WHERE `closedby` = 844;
