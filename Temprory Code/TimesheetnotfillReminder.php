<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel; // Import Excel facade
use App\Exports\TeammemberExport;

class TimesheetnotfillReminder extends Command
{
    // ... (existing code)

    protected $signature = 'command:timesheetnotfillreminder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
        $excludedIds = DB::table('timesheetusers')->pluck('createdby')->unique();
        // This code for saved  but not submitted timesheets
        $teammemberOnlySave = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            ->where('timesheetusers.date', '<', now()->subWeeks(1))
            ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();

        // Get the last submission date for each user only on Sunday and Saturday
        foreach ($teammemberOnlySave as $user) {
            $lastSubmissionDate = DB::table('timesheetusers')
                ->where('createdby', $user->id)
                ->where('date', '<', now()->subWeeks(1))
                ->where(function ($query) {
                    $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                })
                ->max('date');

            $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

            $user->last_submission_date = $lastSubmissionDate;
        }

        //  team members who have never filled a timesheet
        $teammemberNeverFilled = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            ->whereNull('timesheetusers.createdby')
            // ->where('teammembers.status', 1)
            ->whereIn('teammembers.status', [1, 0])
            ->whereIn('teammembers.role_id', [14, 15, 13])
            ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
            ->get();

        // Create an array for the Excel export
        $excelData = $teammemberOnlySave->filter(function ($user) {
            return empty($user->last_submission_date);
        })->merge($teammemberNeverFilled)->map(function ($user) {
            return [
                'team_member' => $user->team_member,
                'emailid' => $user->emailid,
            ];
        })->toArray();


        // Store the Excel file
        $export = new TeammemberExport(collect($excelData));
        $excelFileName = 'Timesheet_Not_Submitted.xlsx';
        Excel::store($export, $excelFileName);

        // get data on mail blade file
        $emailData = array(
            'subject' => "Timesheet not filled till date",
            'teammemberOnlySave' => $teammemberOnlySave->map(function ($user) {
                return (object) [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                    'last_submission_date' => $user->last_submission_date,
                ];
            }),
        );


        Mail::send('emails.timesheetnotfilledremidner', $emailData, function ($msg) use ($emailData, $excelFileName) {
            //    $msg->to('sukhbahadur1993@gmail.com');
            $msg->to('itsupport_delhi@vsa.co.in');
            $msg->cc('Admin_delhi@vsa.co.in');
            // Attach the Excel file to the email
            $msg->attach(storage_path('app/' . $excelFileName), [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            $msg->subject($emailData['subject']);
        });
        // }
    }
}
