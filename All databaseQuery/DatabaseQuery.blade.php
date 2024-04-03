{{-- * Database working --}}
1 current working database is vsa = 27-03-24
2 before it vsaold

{{-- * --}}
{{-- * --}}
{{-- * regarding like query --}}
{{-- on chatgpy --}}
{{-- give me all LIKE related quey with uses description 
in form of table like  1 column heading will be query and 2 column will be description 
i want to copy above table and paste inside vs code  --}}
<pre>
| Query                                                         | Description                                                                                                                        |
|---------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------|
| `SELECT * FROM table WHERE column LIKE 'pattern';`           | Selects all rows from the specified table where the specified column matches the given pattern.                                    |
| `SELECT * FROM table WHERE column LIKE 'prefix%';`           | Selects all rows from the specified table where the specified column starts with the given prefix.                                |
| `SELECT * FROM table WHERE column LIKE '%suffix';`           | Selects all rows from the specified table where the specified column ends with the given suffix.                                  |
| `SELECT * FROM table WHERE column LIKE '%pattern%';`         | Selects all rows from the specified table where the specified column contains the given pattern anywhere within the column value.  |
| `SELECT * FROM table WHERE column LIKE 'pattern' COLLATE utf8_general_ci;` | Performs a case-insensitive match by specifying a case-insensitive collation. Selects all rows where the column matches the pattern without considering case. |
| `SELECT * FROM table WHERE column LIKE '_x%';`              | Selects all rows from the specified table where the specified column starts with any character followed by 'x' and then any sequence of characters. |
</pre>
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` WHERE `created_at` BETWEEN '2024-01-01 16:45:30.000000' AND '2024-03-20
16:45:30.000000' ORDER BY `id` DESC

KAR100470

{{--  Start Hare --}}
SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-10-09' AND '2023-10-16';
{{--  Start Hare --}}
SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-10-09' AND '2023-10-16' AND `client_id` = 267 AND
`assignment_id` = 191 AND `partner` = 844;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-03-08' AND '2024-03-20' AND `client_id` = 68 AND
`assignment_id` = 220;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-16' AND '2024-03-20' AND `client_id`= 237 AND
`assignment_id` = 217;


SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-03-02' AND '2024-03-20' AND `client_id` = 78 AND
`assignment_id` = 193 AND `createdby` = 867;


SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217;



UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'RSW100481'
WHERE `date` BETWEEN '2024-02-26 ' AND '2024-03-20'
AND `client_id` = 267
AND `assignment_id` = 191
AND `partner` = 844;
{{--  Start Hare --}}





UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'RSW100481'
WHERE `date` BETWEEN '2024-03-02' AND '2024-03-20'
AND `client_id` = 78
AND `assignment_id` = 193
AND `createdby` = 814;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'DAL100024'
WHERE `date` BETWEEN '2023-09-16' AND '2024-01-06'
AND `client_id` = 78
AND `assignment_id` = 193;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'CEN100066'
WHERE `date` BETWEEN '2023-09-22' AND '2024-02-07'
AND `client_id` = 149
AND `assignment_id` = 194
AND `createdby` = 841;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'PAT100401'
WHERE `date` BETWEEN '2024-01-08 ' AND '2024-03-20'
AND `client_id` = 152
AND `assignment_id` = 211
AND `partner` = 839;

UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'THC100473'
WHERE `date` BETWEEN '2024-02-22 ' AND '2024-03-20'
AND `client_id` = 108
AND `assignment_id` = 220
AND `partner` = 836;


UPDATE `timesheetusers`
SET `assignmentgenerate_id` = 'THC100224'
WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20'
AND `client_id` = 108
AND `assignment_id` = 201
AND `partner` = 837;

WHERE `date` BETWEEN '2024-02-26 ' AND '2024-03-20'

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-29' AND '2024-03-20' AND `client_id` = 178 AND
`assignment_id` = 220;



SELECT * FROM `timesheetusers`WHERE `date` BETWEEN '2024-02-22 ' AND '2024-03-20' AND `client_id` = 108 AND
`assignment_id` = 220 AND `partner` = 836;

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2023-11-09' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217 AND `partner` = 841;

AND `createdby` = 867

SELECT * FROM `timesheetusers` WHERE `date` BETWEEN '2024-02-16' AND '2024-03-20' AND `client_id` = 237 AND
`assignment_id` = 217;



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
SELECT COUNT(*) FROM assignmentbudgetings WHERE status = 0;

{{-- * count in database --}}
SELECT COUNT(*) as count FROM `assignmentbudgetings` WHERE `closedby` = 844;

{{-- ###################################################################### --}}
{{--  --------------------- 29 sep 2023 joining date--------------- --}}
