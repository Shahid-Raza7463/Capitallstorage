Mode: ANALYSIS

Target:
OverviewDashboardController@OverviewDashboard

Task:
List each dashboard card with:

- Source table(s)
- Query/method used
- How to verify its data directly from DB

No code changes.

Follow AGENTS.md

2222222222222222222222222222222222

Mode: ANALYSIS

Target:
OverviewDashboardController@OverviewDashboard

Task:
For each dashboard output below, explain:

- Source method
- Source table/model
- Filter applied
- Simple SQL/query to verify from DB

Outputs:

- counts
- charts
- overdueEngagements
- highRiskObservations
- auditCountByLocation
- riskExposureByLocation
- auditHealth

No code changes.

Follow AGENTS.md

222222222222222222222222222222222222
filter ke case me
AND created_at >= '2025-04-01'
AND created_at < '2026-04-01';

prompt
SELECT
COUNT(\*) AS total,
SUM(CASE
WHEN LOWER(TRIM(COALESCE(status, ''))) NOT IN
('completed','reviewed','in progress','draft report issued')
THEN 1 ELSE 0 END) AS planned,
SUM(LOWER(TRIM(COALESCE(status, ''))) = 'in progress') AS in_progress,
SUM(LOWER(TRIM(COALESCE(status, ''))) IN ('completed','reviewed')) AS completed
FROM engagements
WHERE organization_id = 1; and is me ek aur filter lagao craeted date 2025-2026 finanical year

output

SELECT
COUNT(\*) AS total,
SUM(
CASE
WHEN LOWER(TRIM(COALESCE(status, ''))) NOT IN
('completed', 'reviewed', 'in progress', 'draft report issued')
THEN 1 ELSE 0
END
) AS planned,
SUM(LOWER(TRIM(COALESCE(status, ''))) = 'in progress') AS in_progress,
SUM(LOWER(TRIM(COALESCE(status, ''))) IN ('completed', 'reviewed')) AS completed
FROM engagements
WHERE organization_id = 1
AND created_at >= '2025-04-01'
AND created_at < '2026-04-01';
