<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BalanceConfirmationReminder extends Command
{
    /**
     * app\Console\Commands\BalanceConfirmationReminder.php
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:balanceconfirmationreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent Reminder Successfull';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle()
    {
        // if (now()->format('H:i') === '18:00') {
        $allAssignmentIds = DB::table('confirmationrem')
            ->distinct()
            ->get();

        // dd($allAssignmentIds);

        foreach ($allAssignmentIds as $assignment) {

            if ($assignment->max_rem != $assignment->remindcount) {
                $assignmentId = $assignment->assignmentgenid;
                // Fetch debtors data for the current assignment ID
                $debtorsdatas = DB::table('debtors')
                    ->where('debtors.assignmentgenerate_id', $assignment->assignmentgenid)
                    ->where('debtors.mailstatus', 1)
                    ->where('debtors.status', 3)
                    ->get();

                foreach ($debtorsdatas as $debtorsdata) {
                    $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $assignment->updated_at)->addDays($assignment->noofdays - 1);
                    $currentdate = Carbon::now()->startOfDay();

                    if ($nextfivedays->isSameDay($currentdate)) {
                        $maildatas = DB::table('templates')
                            ->where('assignmentgenerate_id', $assignmentId)
                            ->where('type', $debtorsdata->type)
                            ->first();

                        if ($maildatas == null) {
                            $maildata = DB::table('templates')
                                ->where('type', $debtorsdata->type)
                                ->first();
                        } else {
                            $maildata = DB::table('templates')
                                ->where('assignmentgenerate_id', $assignmentId)
                                ->where('type', $debtorsdata->type)
                                ->first();
                        }

                        $des = $maildata->description;
                        $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
                        $yummy = [
                            $debtorsdata->name,
                            $debtorsdata->amount,
                            $debtorsdata->year,
                            $debtorsdata->date,
                            $debtorsdata->address
                        ];
                        $description = str_replace($healthy, $yummy, $des);

                        $data = array(
                            'name' => $debtorsdata->name,
                            'email' => $debtorsdata->email,
                            'year' => $debtorsdata->year,
                            'date' => $debtorsdata->date,
                            'amount' => $debtorsdata->amount,
                            'clientid' => $debtorsdata->assignmentgenerate_id,
                            'debtorid' => $debtorsdata->id,
                            'amounthidestatus' => $debtorsdata->amounthidestatus,
                            'type' => $debtorsdata->type,
                            'description' => $description,
                            'yes' => 1,
                            'no' => 0
                        );

                        Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data) {
                            $msg->to($data['email']);
                            $msg->subject('Regarding Pending Confirmation');
                        });

                        DB::table('confirmationrem')
                            ->where('assignmentgenid', $assignmentId)
                            // ->get();
                            ->update([
                                'remindcount' => $assignment->remindcount + 1,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    }
                }
            }
        }
        // }
    }
}
