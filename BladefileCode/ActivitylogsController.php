<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ActivitylogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function getModuleLogs(Request $request, $module)
    {
        $modules = explode(',', $module);


        $allowedModules = ['timesheet_rejceted', 'teammember_credential', 'notification', 'teammember_status', 'teammember', 'assignment', 'leave', 'client', 'confirmation', 'timesheet_requests', 'teammember_rejoining', 'teammember_promotion', 'assignment_team', 'assignment_partner', 'leave_revert'];


        foreach ($modules as $mod) {
            if (!in_array($mod, $allowedModules)) {
                return response()->json(['success' => false, 'message' => 'Invalid module: ' . $mod], 400);
            }
        }

        $logs = DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'logs.performed_by')
            ->leftJoin('teammembers as teamname', 'teamname.id', '=', 'logs.teammember_id')
            ->whereIn('logs.module', $modules)
            ->select(
                'logs.*',
                'createdby.team_member as created_by',
                'teamname.team_member as team_name'
            )
            ->orderByDesc('logs.id')
            ->get();

        $activitylogs = $logs->map(function ($log) {
            $changes = json_decode($log->changed_fields, true);
            $oldData = json_decode($log->old_data, true);
            $newData = json_decode($log->new_data, true);
            $formattedChanges = [];

            $formattedChanges = $this->formatChanges($changes, $log->module);

            $formattedOld = [];
            if (!empty($oldData)) {
                $formattedOld = $this->formatDataForModal($oldData, $log->module, $log->action, $log->teammember_id, $log->created_at);
            }

            $formattedNew = [];
            if (!empty($newData)) {
                $formattedNew =  $this->formatDataForModal($newData, $log->module, $log->action, $log->teammember_id, $log->created_at);
            }

            $log->team_staffcode = $this->getStaffCodeAt($log->teammember_id, $log->created_at);

            $log->formatted_date = Carbon::parse($log->created_at)->format('d-m-Y h:i A');
            $log->formatted_changes = $formattedChanges;
            $log->formatted_old = $formattedOld;
            $log->formatted_new = $formattedNew;

            return $log;
        });

        return response()->json([
            'success' => true,
            'module' => $module,
            'data' => $activitylogs
        ]);
    }

    public function activitylogs(Request $request)
    {
        $filters = $this->getFilters();

        $query = DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'logs.performed_by')
            ->leftJoin('teammembers as teamname', 'teamname.id', '=', 'logs.teammember_id')
            ->select(
                'logs.*',
                'createdby.team_member as created_by',
                'teamname.team_member as team_name'
            );

        // Apply filters
        $query = $this->activitylogsfilter($request, $query);

        // Get ordered results
        $logs = $query->orderByDesc('logs.id')->get();

        // Format activity logs
        $activitylogs = $logs->map(function ($log) {
            // Your existing mapping code (same as before)
            $changes = json_decode($log->changed_fields, true);
            $oldData = json_decode($log->old_data, true);
            $newData = json_decode($log->new_data, true);

            $formattedChanges = [];

            $formattedChanges = $this->formatChanges($changes, $log->module);

            $formattedOld = [];
            if (!empty($oldData)) {
                $formattedOld = $this->formatDataForModal($oldData, $log->module, $log->action, $log->teammember_id, $log->created_at);
            }

            $formattedNew = [];
            if (!empty($newData)) {
                $formattedNew = $this->formatDataForModal($newData, $log->module, $log->action, $log->teammember_id, $log->created_at);
            }

            $log->team_staffcode = $this->getStaffCodeAt($log->teammember_id, $log->created_at);

            $log->formatted_date = Carbon::parse($log->created_at)->format('d-m-Y h:i A');
            $log->formatted_changes = $formattedChanges;
            $log->formatted_old = $formattedOld;
            $log->formatted_new = $formattedNew;

            return $log;
        });

        $request->flash();

        // dd($activitylogs);

        return view('backEnd.teammember.activitylogs', compact('activitylogs', 'filters'));
    }

    // model for data befor update and data after update 
    private function formatModalValue($key, $value, $module = null, $teammember_id = null, $date = null)
    {
        if ($value === null || $value === 'NULL' || $value === '') {
            return 'N/A';
        }

        // Handle team member ID mapping
        if (in_array($key, ['teammember_id', 'leadpartner', 'otherpartner', 'updatedby', 'rejectedby', 'performed_by', 'created_by', 'partner', 'createdby'])) {
            return $this->teamname($value);
        }

        if (in_array($key, ['assignmentmapping_id'])) {
            return $this->assignmentgenrateid($value);
        }

        // Handle role_id mapping
        if ($key == 'role_id') {
            return $this->mapStatus($value, 'rolemapped');
        }

        // Handle status field based on module
        if ($key == 'status') {
            if (in_array($module, ['teammember', 'teammember_rejoining', 'teammember_status', 'teammember_credential'])) {
                return $this->mapStatus($value, 'teammember');
            }
            if (in_array($module, ['leave', 'leave_revert'])) {
                return $this->mapStatus($value, 'leave');
            }
            if ($module == 'timesheet_requests') {
                return $this->mapStatus($value, 'timesheet_requests');
            }
            if ($module == 'timesheet_rejceted') {
                return $this->mapStatus($value, 'timesheet_rejceted');
            }
            if ($module == 'client') {
                return $this->mapStatus($value, 'client');
            }
        }

        // Handle balanceconfirmationstatus
        if ($key == 'balanceconfirmationstatus' && $module == 'confirmation') {
            return $this->mapStatus($value, 'confirmation');
        }

        // Handle timesheet_access
        if ($key == 'timesheet_access' && $module == 'teammember') {
            return $this->mapStatus($value, 'teammember');
        }

        if ($key == 'legalstatus' && $module == 'client') {
            return $this->mapStatus($value, 'legalstatus');
        }

        if ($key == 'classification' && $module == 'client') {
            return $this->mapStatus($value, 'classification');
        }

        if ($key == 'staffcode' && $teammember_id && $date && !in_array($module, ['teammember_promotion', 'teammember_rejoining'])) {
            return $this->getStaffCodeAt($teammember_id, $date);
        }

        // Format datetime values
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                $date = Carbon::parse($value);
                if (strpos($value, ':') !== false && !preg_match('/00:00:00$/', $value) && !preg_match('/00:00$/', $value)) {
                    return $date->format('d-m-Y H:i');
                }
                return $date->format('d-m-Y');
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }

    // helper function 

    public function getStaffCodeAt($teammember_id, $date)
    {
        // Get the latest newstaff_code before or equal to the given date
        $newCode = DB::table('teamrolehistory')
            ->where('teammember_id', $teammember_id)
            ->where('created_at', '<=', $date)
            ->orderByDesc('created_at')
            ->value('newstaff_code');

        if ($newCode) {
            return $newCode;
        }

        // If not found, get the next oldstaff_code after the date
        $oldCode = DB::table('teamrolehistory')
            ->where('teammember_id', $teammember_id)
            ->where('created_at', '>', $date)
            ->orderBy('created_at')
            ->value('oldstaff_code');

        if ($oldCode) {
            return $oldCode;
        }

        //if user not rejoined and promoted teammembers.staffcode
        return DB::table('teammembers')
            ->where('id', $teammember_id)
            ->value('staffcode');
    }

    private function formatChanges($changes, $module)
    {
        $formattedChanges = [];

        if (empty($changes)) {
            return $formattedChanges;
        }

        foreach ($changes as $field => $change) {
            $oldValue = $this->formatValue($change['old'] ?? null);
            $newValue = $this->formatValue($change['new'] ?? null);

            if ($field == 'status') {
                if (in_array($module, ['teammember', 'teammember_rejoining', 'teammember_status', 'teammember_credential'])) {
                    $oldValue = $this->mapStatus($oldValue, 'teammember');
                    $newValue = $this->mapStatus($newValue, 'teammember');
                }
                if (in_array($module, ['leave', 'leave_revert'])) {
                    $oldValue = $this->mapStatus($oldValue, 'leave');
                    $newValue = $this->mapStatus($newValue, 'leave');
                }
                if ($module == 'timesheet_requests') {
                    $oldValue = $this->mapStatus($oldValue, 'timesheet_requests');
                    $newValue = $this->mapStatus($newValue, 'timesheet_requests');
                }
                if ($module == 'timesheet_rejceted') {
                    $oldValue = $this->mapStatus($oldValue, 'timesheet_rejceted');
                    $newValue = $this->mapStatus($newValue, 'timesheet_rejceted');
                }
                if ($module == 'client') {
                    $oldValue = $this->mapStatus($oldValue, 'client');
                    $newValue = $this->mapStatus($newValue, 'client');
                }
            }

            if ($field == 'balanceconfirmationstatus' && $module == 'confirmation') {
                $oldValue = $this->mapStatus($oldValue, 'confirmation');
                $newValue = $this->mapStatus($newValue, 'confirmation');
            }

            if ($field == 'timesheet_access' && $module == 'teammember') {
                $oldValue = $this->mapStatus($oldValue, 'teammember');
                $newValue = $this->mapStatus($newValue, 'teammember');
            }

            if ($field == 'role_id') {
                $oldValue = $this->mapStatus($oldValue, 'rolemapped');
                $newValue = $this->mapStatus($newValue, 'rolemapped');
            }

            if ($field == 'legalstatus') {
                $oldValue = $this->mapStatus($oldValue, 'legalstatus');
                $newValue = $this->mapStatus($newValue, 'legalstatus');
            }
            if ($field == 'classification') {
                $oldValue = $this->mapStatus($oldValue, 'classification');
                $newValue = $this->mapStatus($newValue, 'classification');
            }

            if (in_array($field, ['leadpartner', 'otherpartner', 'updatedby', 'rejectedby'])) {
                $oldValue = $this->teamname($oldValue);
                $newValue = $this->teamname($newValue);
            }

            $formattedChanges[] = [
                'field' => $this->mapFieldName($field),
                'old' => $this->formatDisplayValue($oldValue),
                'new' => $this->formatDisplayValue($newValue),
            ];
        }

        return $formattedChanges;
    }

    private function mapStatus($value, $module)
    {
        if ($value === null) return 'N/A';

        if (in_array($module, ['teammember', 'teammember_rejoining', 'teammember_status', 'teammember_credential', 'client'])) {
            return $value == 1 ? 'Active' : 'Inactive';
        }
        if (in_array($module, ['timesheet_rejceted'])) {
            return $value == 1 ? 'Submitted' : 'Rejected';
        }

        if (in_array($module, ['confirmation'])) {
            return $value == 1 ? 'Opened' : 'Closed';
        }

        switch ($module) {
            case 'leave':
                switch ($value) {
                    case 0:
                        return 'Created';
                    case 1:
                        return 'Approved';
                    case 2:
                        return 'Rejected';
                    default:
                        return $value;
                }

            case 'rolemapped':
                switch ($value) {
                    case 13:
                        return 'Partner';
                    case 14:
                        return 'Manager';
                    case 15:
                        return 'Staff';
                    default:
                        return $value;
                }

            case 'timesheet_requests':
                switch ($value) {
                    case 0:
                        return 'Created';
                    case 1:
                        return 'Approved';
                    case 2:
                        return 'Rejected';
                    default:
                        return $value;
                }

            case 'legalstatus':
                switch ($value) {
                    case 2:
                        return 'Individual';
                    case 3:
                        return 'Proprietorship';
                    case 4:
                        return 'Firm';
                    case 5:
                        return 'Private Limited Company';
                    case 6:
                        return 'Public Company';
                    case 7:
                        return 'Listed Company';
                    case 8:
                        return 'Society';
                    case 9:
                        return 'Trust';
                    case 10:
                        return 'Section 8 Company';
                    case 12:
                        return 'Foreign Company';
                    case 11:
                        return 'AOP';
                    default:
                        return $value;
                }

            case 'classification':
                switch ($value) {
                    case 1:
                        return 'NFRA';
                    case 2:
                        return 'Quality Review';
                    case 3:
                        return 'Peer Review';
                    case 4:
                        return 'Others';
                    default:
                        return $value;
                }

            default:
                return $value;
        }
    }

    private function mapFieldName($field)
    {
        $fields = [
            'balanceconfirmationstatus' => 'Confirmation',
            'status' => 'Status',
            'rejoiniedexitdate' => 'Rejoining Exit Date',
            'rejoiningdate' => 'Rejoining Date',
            'emergencycontactnumber' => 'Emergency Contact Number',
            'team_member' => 'Team Member Name',
            'mobile_no' => 'Mobile Number',
            'dateofbirth' => 'Date Of Birth',
            'pancardno' => 'PAN Card Number',
            'adharcardnumber' => 'Aadhar Number',
            'role_id' => 'Role Name',
            'staffcodenumber' => 'Staff Code Number',
            'staffcode' => 'Staff Code',
            'rejectedby' => 'Rejected By',
            'updatedby' => 'Updated By',
            'otherpartner' => 'Other Partner',
            'leadpartner' => 'Lead Partner',
            'stdcost' => 'Std cost',
            'emailid' => 'Email Id',
            'personalemail' => 'Personal Email',
            'address_proof' => 'Address Proof',
            'mothername' => 'Mother Name',
            'mothernumber' => 'Mother contact Number',
            'fathername' => 'Father Name',
            'fathernumber' => 'Father contact Number',
            'leavingdate' => 'Leaving Date',
            'created_by' => 'Created By',
            'assignmentgenerate_id' => 'Assignment Id',
            'partner' => 'Partner Name',
            'date' => 'Date',
            'workitem' => 'Work Item',
            'location' => 'Location',
            'hour' => 'Hour',
            'createdby' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'has_attachment' => 'Has Attachment',
            'teammember_id' => 'Team Member',
            'teamember_name' => 'Teamember Name',
            'addressupload' => 'Unique Address Document',
            'originaladdressupload' => 'Address Document',
            'profilepic' => 'Profile Picture',
            'aadharupload' => 'Unique Aadhar Document',
            'originalaadharupload' => 'Aadhar Document',
            'originalcancelcheque' => 'Bank Document',
            'cancelcheque' => 'Unique Bank Document',
            'originalpanupload' => 'Pan Card Document',
            'panupload' => 'Unique Pan Card Document',
            'originalappointment_letter' => 'Appointment Letter Document',
            'appointment_letter' => 'Unique Appointment Letter Document',
            'entity' => 'Entity',
            'nameasperbank' => 'Name As Per Bank',
            'nameofbank' => 'Bank Name',
            'bankaccountnumber' => 'Bank Account Number',
            'ifsccode' => 'IFSC Code',
            'qualification' => 'Qualification',
            'document_type' => 'Document Type',
            'document_file' => 'Document File',
            'original_file' => 'Original File',
            'permanentaddress' => 'Permanent Address',
            'communicationaddress' => 'Communication Address',
            'joining_date' => 'Joining Date',
            'timesheet_access' => 'Timesheet Access',
            'gender' => 'Gender',
            'designation' => 'Designation',
            'email' => 'Email',
            // client
            'client_name' => 'Client Name',
            'name' => 'Name',
            'client_code' => 'Client Code',
            'c_address' => 'Client Address',
            'mobileno' => 'Mobile No',
            'panno' => 'PAN No',
            'tanno' => 'TAN No',
            'gstno' => 'GST No',
            'legalstatus' => 'Legal Status',
            'otherclassification' => 'Other Classification',
            'targettype' => 'Target Type',
            'reasonleave' => 'Reason for Leave',
            'assignmentmapping_id' => 'Assignment Id',
        ];

        // retutn maaping field name 
        if (array_key_exists($field, $fields)) {
            return $fields[$field];
        }

        // otherwise default formatting
        return ucfirst(str_replace('_', ' ', $field));
        return $field;
    }

    private function formatValue($value)
    {
        if ($value === null || $value === '') {
            return 'NULL';
        }

        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                $date = \Carbon\Carbon::parse($value);
                // If value contains time and time is not 00:00:00
                if (strpos($value, ':') !== false && !preg_match('/00:00:00$/', $value) && !preg_match('/00:00$/', $value)) {
                    return $date->format('d-m-Y H:i');
                }
                return $date->format('d-m-Y');
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }

    private function formatDataForModal($data, $module, $action = null, $teammember_id = null, $date = null)
    {
        if (empty($data)) {
            return [];
        }

        // Fields to hide for all modules
        $alwaysHideFields = ['id', 'created_at', 'updated_at'];

        // Module-wise fields to hide
        $moduleHideFields = [
            'teammember' => ['mentor_id', 'title_id', 'employment_status', 'department', 'originalnda', 'teamlead', 'nda', 'rejoining_date', 'reasonofleaving', 'dateofresign', 'created_by', 'linkedin', 'about', 'verify', 'relievingstatus', 'category', 'cost_hour', 'salary_range', 'monthly_gross_salary', 'pf_applicable', 'timesheet_applicable', 'taxtds', 'taxgrosssalary', 'taxpf', 'rejoiningsamepost', 'change_type', 'staffcodenumber'],
            'assignment_team' => ['type', 'viewerteam'],
            'leave' => ['leavetype'],
            'timesheet_rejceted' => ['timesheetid', 'client_id', 'assignment_id', 'project_id', 'job_id', 'billable_status', 'description', 'updatedby', 'totalhour', 'rejectedby'],
            'notification' => ['targettype'],
            'client' => ['name', 'parent_id', 'clientdesignation', 'kind_attention', 'password', 'scopeofwork', 'c_state', 'associatedfrom', 'leadpartner', 'dateofincorporation', 'otherpartner', 'companygroup', 'engagementpartner', 'clientdob', 'createdbyadmin_id', 'updatedbyadmin_id', 'capital', 'borrowings', 'networth'],
            'teammember_rejoining' => [],
            'teammember_promotion' => [],
            'assignment_partner' => ['type'],
            'assignment' => ['assignment_id', 'fees', 'gst', 'roleassignment', 'independenceform', 'filecreationdate', 'modifieddate', 'auditcompletiondate', 'documentationdate', 'leadpartnerhour', 'otherpartnerhour'],
        ];

        $hideFields = array_merge($alwaysHideFields, $moduleHideFields[$module] ?? []);

        $formattedData = [];

        foreach ($data as $key => $value) {
            // Skip hidden fields
            if (in_array($key, $hideFields)) {
                continue;
            }

            // Get readable field name
            $readableKey = $this->mapFieldName($key);

            // Format value
            $formattedValue = $this->formatModalValue(
                $key,
                $value,
                $module,
                $teammember_id,
                $date
            );

            $formattedData[$readableKey] = $formattedValue;
        }

        return $formattedData;
    }



    protected function activitylogsfilter($request, $query)
    {
        if (!empty($request->teammemberid)) {
            $query->where('logs.teammember_id', $request->teammemberid);
        }

        if (!empty($request->createdbyid)) {
            $query->where('logs.performed_by', $request->createdbyid);
        }

        if (!empty($request->modulename)) {
            $query->where('logs.module', $request->modulename);
        }

        if (!empty($request->actionname)) {
            $query->where('logs.action', $request->actionname);
        }

        return $query;
    }

    private function getFilters()
    {
        $filters['status'] = DB::table('activitylogs_details')
            ->select('action')
            ->distinct()
            ->whereNotNull('action')
            ->orderBy('action')
            ->pluck('action')
            ->values();

        $filters['module'] = DB::table('activitylogs_details')
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module')
            ->values();

        $filters['teamname'] = DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as teamname', 'teamname.id', '=', 'logs.teammember_id')
            ->select('teamname.id', 'teamname.team_member')
            ->distinct()
            ->whereNotNull('teamname.team_member')
            ->orderBy('teamname.team_member')
            ->get();

        $filters['created_by'] = DB::table('activitylogs_details as logs')
            ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'logs.performed_by')
            ->select('createdby.id', 'createdby.team_member')
            ->distinct()
            ->whereNotNull('createdby.team_member')
            ->orderBy('createdby.team_member')
            ->get();

        return $filters;
    }

    private function teamname($value)
    {
        if (empty($value)) {
            return 'N/A';
        }

        $name = DB::table('teammembers')
            ->where('id', $value)
            ->value('team_member');

        return $name ?? 'N/A';
    }

    private function assignmentgenrateid($value)
    {
        if (empty($value)) {
            return 'N/A';
        }

        $name = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->where('assignmentteammappings.assignmentmapping_id', $value)
            ->value('assignmentmappings.assignmentgenerate_id');

        return $name ?? 'N/A';
    }

    private function formatDisplayValue($value)
    {
        if ($value === null || $value === 'NULL' || $value === '') {
            return 'N/A';
        }

        return $value;
    }
}
