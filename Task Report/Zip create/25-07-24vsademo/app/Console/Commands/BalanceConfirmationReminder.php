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
         if (Carbon::now()->isDayOfWeek(Carbon::MONDAY) || Carbon::now()->isDayOfWeek(Carbon::THURSDAY)) {
            // Check if the current time is 10:00 AM
            if (Carbon::now()->hour === 10 && Carbon::now()->minute === 0) {
        $balanceConfirmations = DB::table('debtors')
        ->where('status', 3)
       // ->take(6)
        ->get();
    
    $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    
    foreach ($balanceConfirmations as $balanceConfirmation) {
        $debtorReminder = DB::table('confirmationrem')
            ->where('debtorid', $balanceConfirmation->id)
            ->first();
    
        if ($debtorReminder == null || $debtorReminder->remindcount < 7) {
            $mailDataQuery = DB::table('templates')
                ->where('type', $balanceConfirmation->type);
    
            if ($debtorReminder == null) {
                $mailDataQuery->where('assignmentgenerate_id', $balanceConfirmation->assignmentgenerate_id);
            }
    
            $mailData = $mailDataQuery->first();
    
            if ($mailData == null) {
                $mailData = DB::table('templates')
                    ->where('type', $balanceConfirmation->type)
                    ->first();
            }
    
            $des = $mailData->description;
            $yummy = [
                $balanceConfirmation->name,
                $balanceConfirmation->amount,
                $balanceConfirmation->year,
                $balanceConfirmation->date,
                $balanceConfirmation->address
            ];
            $description = str_replace($healthy, $yummy, $des);
    
            $data = [
                'name' => $balanceConfirmation->name,
                'email' => $balanceConfirmation->email,
                'year' => $balanceConfirmation->year,
                'date' => $balanceConfirmation->date,
                'amount' => $balanceConfirmation->amount,
                'clientid' => $balanceConfirmation->assignmentgenerate_id,
                'debtorid' => $balanceConfirmation->id,
                'amounthidestatus' => $balanceConfirmation->amounthidestatus,
                'type' => $balanceConfirmation->type,
                'description' => $description,
                'yes' => 1,
                'no' => 0
            ];
    
            Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject('Regarding Pending Confirmation');
            });
    
            if ($debtorReminder == null) {
                DB::table('confirmationrem')->insert([
                    'assignmentgenid' => $balanceConfirmation->assignmentgenerate_id,
                    'debtorid' => $balanceConfirmation->id,
                    'remindcount' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('confirmationrem')
                    ->where('id', $debtorReminder->id)
                    ->update([
                        'remindcount' => $debtorReminder->remindcount + 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }
    }
}
        }
    }
}
