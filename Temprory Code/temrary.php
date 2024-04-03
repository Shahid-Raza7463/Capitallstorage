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

    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
              // $update = DB::table('debtors')
            //     ->where('mailstatus', 1)
            //     // ->get();
            //     ->update(['mailstatus' => 0]);
            // dd($update);
            // dd('send');

            
    // Route::get('/confirmationauthotp',  [BackEndController::class, 'confirmationauthotp']);

    public function confirmationauthotp(Request $request)
    {

        if ($request->ajax()) {
            if (isset($request->id)) {
                $authotp = DB::table('debtors')->where('id.id', $request->id)->first();
                // dd($authotp->mobile_no);
                $otpap = sprintf("%06d", mt_rand(1, 999999));

                $data = array(
                    'taskname' =>  $request->taskname,
                    'duedate' =>  $request->duedate,
                    'description' =>  $request->description,
                    'otpap' =>  $otpap,

                );

                Mail::send('emails.confirmationotp', $data, function ($msg) use ($data, $teammember) {
                    $msg->to($teammember);
                    $msg->subject('VSA Balance Confirmation OTP');
                });
                return response()->json($authotp);
            }
        }
    }


    public function otpapstore(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        try {
            $data = $request->except(['_token']);

            $otp = $request->otp;

            $otpm = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->first();
            if ($otp == $otpm->otp) {

                DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
                    'status' => '1',
                    'otpdate' => date('Y-m-d H:i:s')
                ]);
                $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();


                $output = array('msg' => 'otp match successfully and verified');
                return back()->with('success', $output);
            } else {
                $output = array('msg' => 'otp did not match! Please enter valid otp');
                return back()->with('success', $output);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    // Start Hare 

    //         Route::get('sendRequestReminder', [TimesheetrequestController::class, 'sendRequestReminder']);
    //       Route::get('/timesheetrequest/reminder/list',  [TimesheetrequestController::class, 'timesheetrequest_list']);
    //     ConfirmationController routes
    // timesheetrequest_list
    public function timesheetrequest_list(Request $request)
    {

        $timesheetRequest = DB::table('timesheetrequests')
            ->where('id', $request->id)
            ->latest()
            ->first();

        $timesheetrequestreminderlist =  DB::table('timesheetrequestreminderlist')
            ->where('timesheetrequestid', $request->id)->get();

        return response()->json([
            'timesheetRequest' => $timesheetRequest,
            'timesheetrequestreminderlist' => $timesheetrequestreminderlist,
        ]);
    }
    public function sendRequestReminder(Request $request)
    {
        //	dd('hi');
        $timesheetRequest = DB::table('timesheetrequests')
            ->where('createdby', auth()->user()->teammember_id)
            // ->where('status', 0)
            ->orderBy('id', 'desc')
            ->first();
        //	dd($timesheetRequest);


        // dd($timesheetRequest);
        // Debugging: Print out the generated SQL query
        $query = DB::table('timesheetrequests')
            ->where('createdby', auth()->user()->teammember_id)
            //->where('status', 1)
            ->latest()
            ->toSql();
        //  dd($query);

        // Check if $timesheetRequest is not null
        if (date('Y-m-d') < $timesheetRequest->fivedaysdate) {

            if ($timesheetRequest->remindercount < 6) {

                if ($timesheetRequest->reminderdatecount != date('Y-m-d')) {
                    //   dd('hi');
                    if ($timesheetRequest->status == 0) {
                        //   dd('hi');
                        // If the timesheet request exists, get the partner column value
                        $partner = $timesheetRequest->partner;
                        //dd($partner);
                        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();
                        $teammembermail = Teammember::where('id', $timesheetRequest->partner)->pluck('emailid')->first();
                        $client_name = Client::where('id', $timesheetRequest->client_id)->pluck('client_name')->first();
                        if ($timesheetRequest->status == 0) {
                            $data = array(
                                'teammember' => $name ?? '',
                                'email' => $teammembermail ?? '',
                                'id' => $timesheetRequest->id ?? '',
                                'client_id' => $client_name ?? '',
                                'reason'     =>     $timesheetRequest->reason ?? '',
                            );
                            // dd($data);

                            // Mail::send('emails.timesheetrequestreminder', $data, function ($msg) use ($data) {
                            //   $msg->to($data['email']);
                            //  $msg->cc('Vinitayadav@capitall.io');

                            //  // $msg->cc('hr@kgsomani.com');
                            //   $msg->subject('Timesheet Submission Reminder Request | '. $data['teammember']);
                            // });

                            $url = URL::to('/timesheetrequestlist') ?? '';
                            $title = "timesheetrequestreminder";
                            $template = $this->getTemplateData($title);
                            // dd($template);  
                            $to = ($data['email']);
                            $cc = ($template['cc']);
                            $this->sendTicketEmail($to, $cc, $title, $data, $url);
                        }
                        DB::table('timesheetrequests')->where('id', $timesheetRequest->id)->update([
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                        ]);

                        DB::table('timesheetrequestreminderlist')->insert([
                            'timesheetrequestid'  => $timesheetRequest->id,
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // Send mail to the partner
                        // Your code to send the mail goes here
                        $output = array('msg' => 'Reminder Mail send Successfully');
                        return back()->with('success', $output);
                    } elseif ($timesheetRequest->status == '1' && $timesheetRequest->validate == null) {

                        //dd('final');
                        # code...
                        $partner = 157;
                        //dd($partner);
                        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();
                        $teammembermail = Teammember::where('id', 157)->pluck('emailid')->first();
                        $client_name = Client::where('id', $timesheetRequest->client_id)->pluck('client_name')->first();

                        $data = array(
                            'teammember' => $name ?? '',
                            'email' => $teammembermail ?? '',
                            'id' => $timesheetRequest->id ?? '',
                            'client_id' => $client_name ?? '',
                            'reason'     =>     $timesheetRequest->reason ?? '',
                        );
                        // dd($data);

                        Mail::send('emails.timesheetrequestreminder', $data, function ($msg) use ($data) {
                            $msg->to($data['email']);
                            $msg->cc('Vinitayadav@capitall.io');

                            // $msg->cc('hr@kgsomani.com');
                            $msg->subject('Timesheet Submission Request | ' . $data['teammember']);
                        });
                        DB::table('timesheetrequests')->where('id', $timesheetRequest->id)->update([
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                        ]);

                        DB::table('timesheetrequestreminderlist')->insert([
                            'timesheetrequestid'  => $timesheetRequest->id,
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        // Send mail to the Final partner
                        // Your code to send the mail goes here

                        $output = array('msg' => 'Final Reminder Mail send Successfully');
                        return back()->with('success', $output);
                    } else {
                        $output = array('msg' => 'No Data');
                        return back()->with('success', $output);
                    }
                } else {
                    $output = array('msg' => 'Already Mail send Successfully Today');
                    return back()->with('success', $output);
                }
            }
        }
    }


    //*
    // Start Hare 

    // public function mail(Request $request)
    // {
    //     try {
    //         $data = $request->except(['_token']);

    //         $debtor = DB::table('debtors')
    //             ->where('assignmentgenerate_id', $request->clientid)
    //             ->where('type', $request->type)
    //             ->where('mailstatus', 0)
    //             ->get();

    //         foreach ($debtor as $debtors) {
    //             if ($request->teammember_id) {
    //                 // cc mail
    //                 $teammembermail = Teammember::whereIn('id', $request->teammember_id)->pluck('emailid')->toArray();
    //             }

    //             $des = $request->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
    //             $description = str_replace($healthy, $yummy, $des);

    //             $data = array(
    //                 'subject' => $request->subject,
    //                 'name' =>  $debtors->name,
    //                 'email' =>  $debtors->email,
    //                 'year' =>  $debtors->year,
    //                 'date' =>  $debtors->date,
    //                 'amount' =>  $debtors->amount,
    //                 'clientid' => $debtors->assignmentgenerate_id,
    //                 'debtorid' => $debtors->id,
    //                 'description' => $description,
    //                 'teammembermail' => $teammembermail ?? '',
    //                 'yes' => 1,
    //                 'no' => 0
    //             );

    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
    //                 $msg->to($data['email']);
    //                 $msg->subject($data['subject']);

    //                 if ($request->teammember_id) {
    //                     $msg->cc($data['teammembermail']);
    //                 }
    //             });

    //             // If mail sent successfully, update mailstatus to 1
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 1,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => 'Mail Sent Successfully');
    //         return back()->with('success', $output);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);

    //         // If mail sending fails, update mailstatus to 0
    //         foreach ($debtor as $debtors) {
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 0,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    // public function mail(Request $request)
    // {
    //     try {
    //         $data = $request->except(['_token']);

    //         $debtor = DB::table('debtors')
    //             ->where('assignmentgenerate_id', $request->clientid)
    //             ->where('type', $request->type)
    //             ->where('mailstatus', 0)
    //             ->get();

    //         foreach ($debtor as $debtors) {
    //             if ($request->teammember_id) {
    //                 // cc mail
    //                 $teammembermail = Teammember::whereIn('id', $request->teammember_id)->pluck('emailid')->toArray();
    //             }

    //             $des = $request->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
    //             $description = str_replace($healthy, $yummy, $des);

    //             $data = array(
    //                 'subject' => $request->subject,
    //                 'name' =>  $debtors->name,
    //                 'email' =>  $debtors->email,
    //                 'year' =>  $debtors->year,
    //                 'date' =>  $debtors->date,
    //                 'amount' =>  $debtors->amount,
    //                 'clientid' => $debtors->assignmentgenerate_id,
    //                 'debtorid' => $debtors->id,
    //                 'description' => $description,
    //                 'teammembermail' => $teammembermail ?? '',
    //                 'yes' => 1,
    //                 'no' => 0
    //             );

    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
    //                 $msg->to($data['email']);
    //                 $msg->subject($data['subject']);

    //                 if ($request->teammember_id) {
    //                     $msg->cc($data['teammembermail']);
    //                 }
    //             });

    //             // If mail sent successfully, update mailstatus to 1
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 1,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => 'Mail Sent Successfully');
    //         return back()->with('success', $output);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);

    //         // If mail sending fails, update mailstatus to 2
    //         DB::table('debtors')
    //             ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //             ->where('id', $debtors->id)
    //             ->update([
    //                 'mailstatus' => 2,
    //                 'updated_at' => now()
    //             ]);

    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }


    // public function pendingmail($id)
    // {
    //     // dd($id);
    //     try {
    //         $usermail = DB::table('debtors')->where('id', $id)->first();

    //         // Get mail for Debitor
    //         if ($usermail->type == 1) {
    //             // dd('debitor');
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         // Get mail for creater
    //         elseif ($usermail->type == 2) {
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         // Get mail for bank
    //         else {
    //             // dd('bank');
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();
    //             // dd($maildata);
    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         dd('hi4');
    //         $output = array('msg' => 'Mail Send Successfully');
    //         return back()->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    public function mail(Request $request)
    {
        // dd($request);
        //    if($request->description){
        //     $print =DB::table('templates')->where('description', 'LIKE', '%' . '$name' . '%' )->first();
        //     dd('hi');
        //    }
        //    dd($request);
        // $request->validate([
        //     'file' => 'required'
        // ]);

        try {
            $data = $request->except(['_token']);

            $debtor = DB::table('debtors')->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)->where('mailstatus', 0)->get();
            //  dd($debtor);

            if ($debtor[0]->mailstatus == 0) {
                $updateit = DB::table('debtors')
                    ->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)
                    ->update([
                        'mailstatus'         => 2,
                        'updated_at'         =>   date("Y-m-d H:i:s")
                    ]);
            }
            foreach ($debtor as $debtors) {
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                // $description = str_replace('$name', $debtors->name, $request->description); 
                //  $description = str_replace('44247', $debtors->amount, $request->description);
                $des = $request->description;
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
                    //       'fromemail' =>  $request->fromemail,
                    'name' =>  $debtors->name,
                    'email' =>  $debtors->email,
                    'year' =>  $debtors->year,
                    'date' =>  $debtors->date,
                    'amount' =>  $debtors->amount,
                    'clientid' => $debtors->assignmentgenerate_id,
                    'debtorid' => $debtors->id,
                    'description' => $description,
                    'teammembermail' => $teammembermail ?? '',
                    'yes' => 1,
                    'no' => 0
                );


                Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
                    $msg->to($data['email']);
                    //  $msg->from('arihant@kgsomani.com', 'Kgskonnect');
                    // $msg->cc($teammembermail);
                    $msg->subject($data['subject']);

                    if ($request->teammember_id) {
                        $msg->cc($data['teammembermail']);
                    }
                });

                DB::table('debtors')
                    ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)->where('id', $debtors->id)->update([
                        'mailstatus'         => 1,
                        'updated_at'         =>   date("Y-m-d H:i:s")
                    ]);
            }
            $output = array('msg' => 'Mail Send Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    public function pendingmail($id)
    {
        // dd($id);
        try {
            $usermail = DB::table('debtors')->where('id', $id)->select('email')->first();
            // dd($usermail->email);
            $data = array(
                'email' => $usermail->email ?? '',
            );
            Mail::send('emails.testingmail', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject('Subject goes to hare');
            });
            $output = array('msg' => 'Mail Send Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
