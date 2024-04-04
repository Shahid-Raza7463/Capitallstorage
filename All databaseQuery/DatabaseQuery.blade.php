{{-- * Database working --}}
1 current working database is vsa = 27-03-24
2 before it vsaold

{{-- * my sql search using like  --}}
{{--  Start Hare --}}
<pre>
LIKE:          Used for pattern matching using wildcard characters (% for zero or more characters, _ for a single character).
LIKE %...%:    Similar to LIKE, but with placeholders for text that can be matched anywhere within the column value.
NOT LIKE:       Opposite of LIKE, used to exclude rows that match a certain pattern.
NOT LIKE %...%:   Similar to NOT LIKE, but with placeholders for text that should not be matched anywhere within the column value.
=:                Checks for exact equality.
!=:              Checks for inequality.
REGEXP:          Used for pattern matching using regular expressions.
REGEXP ^...$:    Similar to REGEXP, but matches the entire column value against the provided regular expression pattern.
NOT REGEXP:      Opposite of REGEXP, used to exclude rows that match a certain regular expression pattern.
= '':            Checks if the column value is an empty string.
!= '':           Checks if the column value is not an empty string.
IN (...):        Checks if the column value is within a specified list of values.
NOT IN (...):    Checks if the column value is not within a specified list of values.
BETWEEN:         Checks if the column value is within a specified range.
NOT BETWEEN:     Checks if the column value is not within a specified range.
IS NULL:         Checks if the column value is NULL.
IS NOT NULL:     Checks if the column value is not NULL.
</pre>
{{--  Start Hare --}}
{{-- * regarding regular experation --}}
{{--  Start Hare --}}
<pre>
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#                                                Query                                             #                Heading Point                #                                      Explanation                                       #
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#  SELECT * FROM table WHERE column REGEXP 'pattern';                                                #              Basic Pattern Matching:             #  Select rows where a specific column matches a pattern.                                     #
#  SELECT * FROM table WHERE column REGEXP BINARY 'pattern';                                         #           Case-Insensitive Matching:            #  Select rows where a column matches a pattern regardless of case.                              #
#  SELECT * FROM table WHERE column REGEXP '.abc';                                                    #             Matching Any Character:              #  Select rows where a column contains any character followed by 'abc'.                           #
#  SELECT * FROM table WHERE column REGEXP '[ab]';                                                    #          Matching Specific Characters:          #  Select rows where a column contains 'a' or 'b'.                                               #
#  SELECT * FROM table WHERE column REGEXP '[0-9]abc';                                                #         Matching Ranges of Characters:         #  Select rows where a column contains any digit followed by 'abc'.                               #
#  SELECT * FROM table WHERE column REGEXP 'a{3}';                                                    #             Matching Repetitions:              #  Select rows where a column contains 'a' repeated 3 times.                                      #
#  SELECT * FROM table WHERE column NOT REGEXP 'abc';                                                 #               Negating Matches:                #  Select rows where a column does not contain 'abc'.                                              #
#  SELECT * FROM table WHERE column REGEXP '^abc';                                                    #      Anchoring Matches to Start/End:       #  Select rows where a column starts with 'abc'.                                                    #
#  SELECT * FROM table WHERE column REGEXP 'abc$';                                                    #      Anchoring Matches to Start/End:       #  Select rows where a column ends with 'abc'.                                                      #
#  SELECT * FROM table WHERE column REGEXP '^a.*z$';                                                  #           Combining Conditions:            #  Select rows where a column starts with 'a' and ends with 'z'.                                   #
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

</pre>

{{-- * regarding like query --}}
{{-- on chatgpy --}}
{{-- give me all LIKE related quey with uses description 
in form of table like  1 column heading will be query and 2 column will be description 
i want to copy above table and paste inside vs code  --}}

<pre>
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #    Query                                                        #                     Description                                                                     #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #  1. `SELECT * FROM table WHERE column LIKE 'pattern';`           #  Selects all rows from the specified table where the specified column matches the given pattern  #
    #  2. `SELECT * FROM table WHERE column LIKE 'prefix%';`           #  Selects all rows from the specified table where the specified column starts with the given prefix.#
    #  3. `SELECT * FROM table WHERE column LIKE '%suffix';`           #  Selects all rows from the specified table where the specified column ends with the given suffix.  #
    #  4. `SELECT * FROM table WHERE column LIKE '%pattern%';`         #  Selects all rows from the specified table where the specified column contains the given pattern anywhere within the column value.  #
    #  5. `SELECT * FROM table WHERE column LIKE 'pattern' COLLATE utf8_general_ci;` # Performs a case-insensitive match by specifying a case-insensitive collation. Selects all rows where the column matches the pattern without considering case. #
    #  6. `SELECT * FROM table WHERE column LIKE '_x%';`              #  Selects all rows from the specified table where the specified column starts with any character followed by 'x' and then any sequence of characters.  #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
</pre>
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` WHERE `assignmentgenerate_id` LIKE 'JES100152';
SELECT * FROM `assignmentbudgetings` WHERE `created_at` BETWEEN '2024-01-01 16:45:30.000000' AND '2024-03-20
16:45:30.000000' ORDER BY `id` DESC




{{--  Start Hare --}}
{{-- *regarding trigger --}}
{{--  Start Hare create trigger using sql tab --}}
{{-- 1.create users table 
2.create answer table  --}}
CREATE TRIGGER `hello` AFTER UPDATE ON `users`
FOR EACH ROW INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare create trigger using sql tab --}}
CREATE TRIGGER `new` AFTER UPDATE ON `admins`
FOR EACH ROW INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare using trigger tab  --}}
{{-- go to Definition row and paste this code  --}}

INSERT INTO `answers`(`is_correct_answer`)
VALUES(
'1'
)
{{--  Start Hare --}}

{{-- * regarding REGEXP --}}
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` WHERE `assignmentgenerate_id` REGEXP 'SRI';
{{--  Start Hare --}}

{{-- * regarding ORDER BY --}}
{{--  Start Hare --}}
SELECT * FROM `assignmentbudgetings` ORDER BY `id` DESC
INSERT INTO `activitylogs` (`id`, `user_id`, `activitytitle`, `description`, `ip_address`, `created_at`, `updated_at`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL)
TRUNCATE `activitylogs`

"DROP TABLE `activitylogs`

CREATE TABLE `vsaclient` (
`id` int(11) DEFAULT NULL,
`client_name` varchar(42) DEFAULT NULL,
`c_address` varchar(130) DEFAULT NULL,
`legalstatus` varchar(13) DEFAULT NULL,
`panno` varchar(11) DEFAULT NULL,
`tanno` varchar(10) DEFAULT NULL,
`gstno` varchar(15) DEFAULT NULL,
`status` int(11) DEFAULT NULL,
`classification` int(11) DEFAULT NULL,
`client_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci

INSERT INTO `admins`(`name`, `email`, `password`)
VALUES(
'shahid',
'shahid@example.com',
'password123'
);

UPDATE `admins`
SET `password` = 'shshis345'
WHERE `id` = 2;

UPDATE `admins`
SET `password` = 'new_password'
WHERE `id` = 2;


DELETE FROM `users` WHERE 0
{{--  Start Hare --}}

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
