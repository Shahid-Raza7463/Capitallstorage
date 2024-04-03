<?php

namespace App\Http\Controllers;

use App\Models\Debtor;
use App\Models\Teammember;
use App\Models\Client;
use App\Models\Template;
use App\Models\Assignmentbudgeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class ConfirmationController extends Controller
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
    public function indexview($assignmentgenerate_id)
    {
        $teammember = Teammember::where('role_id', '=', 15)->orwhere('role_id', '=', 14)->orwhere('role_id', '=', 13)->with('title', 'role')->get();
        $clientList =  Assignmentbudgeting::where('assignmentgenerate_id', $assignmentgenerate_id)->first();

        $clientdebit =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 1)->get();
        //dd($clientdebit);
        $clientcredit  =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 2)->get();
        $clientbank =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 3)->get();
        $debtortemplate =  Template::where('type', '1')->first();

        return view('backEnd.confirmation.index', compact('debtortemplate', 'clientList', 'clientdebit', 'teammember', 'clientcredit', 'clientbank', 'assignmentgenerate_id'));
    }
    public function view($id)
    {
        $debtorconfirmation = DB::table('debtorconfirmations')->where('debtor_id', $id)->get();
        return view('backEnd.confirmation.view', compact('debtorconfirmation'));
    }
    public function template(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->template_id)) {
                $client = DB::table('templates')->where('type', $request->template_id)->first();

                return response()->json($client);
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function mail(Request $request)
    {
        try {

            $data = $request->except(['_token']);

            $debtor = DB::table('debtors')->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)->where('mailstatus', 0)->get();
            $draftcheck = DB::table('templates')->where('type', $request->type)->first()->draftstatus;
            // dd($draftcheck == 0);
            if ($draftcheck == 0) {
                $output = array('msg' => 'Mail draft is pending please save your draft');
                return back()->with('statuss', $output);
            }

            foreach ($debtor as $debtors) {
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                $des = $request->description;
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
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
                    $msg->subject($data['subject']);

                    if ($request->teammember_id) {
                        $msg->cc($data['teammembermail']);
                    }
                });

                DB::table('debtors')
                    ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)->where('id', $debtors->id)->update([
                        'mailstatus'         => 1,
                        'status'         => 3,
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

        try {
            $usermail = DB::table('debtors')->where('id', $id)->first();

            // Get mail for Debitor
            if ($usermail->type == 1) {
                // dd('debitor');
                $this->sendEmail($usermail);
            }
            // Get mail for crediter
            elseif ($usermail->type == 2) {
                // dd('crediter');
                $this->sendEmail($usermail);
            }
            // Get mail for bank
            else {
                // dd('bank');
                $this->sendEmail($usermail);
            }
            // dd('hi4');
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

    public function sendEmail($usermail)
    {
        $maildata = DB::table('templates')->where('type', $usermail->type)->first();

        $des = $maildata->description;
        $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
        $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
        $description = str_replace($healthy, $yummy, $des);


        $data = array(
            'name' =>  $usermail->name,
            'email' =>  $usermail->email,
            'year' =>  $usermail->year,
            'date' =>  $usermail->date,
            'amount' =>  $usermail->amount,
            'clientid' => $usermail->assignmentgenerate_id,
            'debtorid' => $usermail->id,
            'description' => $description,
            'yes' => 1,
            'no' => 0
        );
        Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            $msg->subject('Regarding Pending Confirmation');
        });

        DB::table('balanceconfirmationreminder')->insert([
            'debtorsid'     =>    $usermail->id,
            'remindercount'     =>     1,
            'reminderdatecount'     =>    date('Y-m-d'),
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);
    }

    public function confirmationAccept(Request $request)
    {
        $clientid = $request->clientid;
        $debtorid = $request->debtorid;
        $yes = $request->yes;
        $no = $request->no;

        return view('backEnd.confirmationaccept', compact('clientid', 'debtorid', 'yes', 'no'));
    }

    // save as draft
    public function saveMaildraft(Request $request)
    {
        // dd($request);

        $request->validate([
            'type' => "required",
            'description' => "required"
        ]);
        try {
            $savedraft = DB::table('templates')
                ->where('type', $request->type)
                ->update([
                    'description' => $request->description,
                    'draftstatus' => 0,
                ]);

            $output = array('msg' => 'Mail save as a draft');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    // final save
    public function saveMail(Request $request)
    {
        // dd($request);
        try {
            $savedraft = DB::table('templates')
                ->where('type', $request->type)
                ->update([
                    'draftstatus' => 1,
                ]);

            $output = array('msg' => 'Mail saved successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function balanceconfirmationreminderlist(Request $request)
    {
        $balanceconfirmationreminderlist =  DB::table('balanceconfirmationreminder')
            ->where('debtorsid', $request->id)
            ->latest()
            ->take(5)
            ->get();
        // dd($timesheetrequestreminderlist);

        return response()->json([
            'balanceconfirmationreminderlist' => $balanceconfirmationreminderlist,
        ]);
    }


    // public function confirmationauthotp(Request $request)
    // {
    //     if ($request->ajax()) {
    //         if (isset($request->id)) {
    //             dd($request);
    //             dd('accept');

    //             $users = DB::table('debtors')->where('id', $request->id)->first();
    //             $otp = sprintf("%06d", mt_rand(1, 999999));

    //             $data = array(
    //                 'email' =>  $users->email,
    //                 'otp' =>  $otp,
    //             );
    //             Mail::send('emails.balanceconfirmotp', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('VSA Balance Confirmation OTP');
    //             });

    //             $update = DB::table('debtors')
    //                 ->where('id', $request->id)->update([
    //                     'otp' =>  $otp,
    //                     'otpverifydate' => date('Y-m-d H:i:s'),
    //                 ]);
    //             // dd($update);
    //             // return response()->json($otp);
    //             // return response()->json('plaese  enter otp');
    //             // $otpsuccessmessage = 'I have sent otp please enter otp';
    //             // return response()->json($otpsuccessmessage);

    //             $otpsuccessmessage = 'I have sent otp please enter otp';
    //             return response()->json([
    //                 'otpsuccessmessage' => $otpsuccessmessage,
    //                 'debitid' => $users->id,
    //                 'assignmentgenerate_id' => $users->assignmentgenerate_id,
    //                 'type' => $users->type,
    //                 'status' => 0,
    //             ]);
    //         }
    //     }
    // }
    public function confirmationauthotp(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->id)) {
                if ($request->status == 1) {
                    // dd($request);
                    // dd('accept');

                    $users = DB::table('debtors')->where('id', $request->id)->first();
                    $otp = sprintf("%06d", mt_rand(1, 999999));

                    $data = array(
                        'email' =>  $users->email,
                        'otp' =>  $otp,
                    );
                    Mail::send('emails.balanceconfirmotp', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject('VSA Balance Confirmation OTP');
                    });

                    $update = DB::table('debtors')
                        ->where('id', $request->id)->update([
                            'otp' =>  $otp,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                        ]);
                    // dd($update);
                    // return response()->json($otp);
                    // return response()->json('plaese  enter otp');
                    // $otpsuccessmessage = 'I have sent otp please enter otp';
                    // return response()->json($otpsuccessmessage);

                    $otpsuccessmessage = 'I have sent otp please enter otp';
                    return response()->json([
                        'otpsuccessmessage' => $otpsuccessmessage,
                        'debitid' => $users->id,
                        'assignmentgenerate_id' => $users->assignmentgenerate_id,
                        'type' => $users->type,
                        'status' => $request->status,
                    ]);
                } else {

                    // dd('refuje');

                    $users = DB::table('debtors')->where('id', $request->id)->first();

                    $otp = sprintf("%06d", mt_rand(1, 999999));

                    $data = array(
                        'email' =>  $users->email,
                        'otp' =>  $otp,
                    );

                    Mail::send('emails.balanceconfirmotp', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject('VSA Balance Confirmation refuse OTP');
                    });
                    // dd($data);
                    $update = DB::table('debtors')
                        ->where('id', $request->id)->update([
                            'otp' =>  $otp,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                        ]);
                    // dd($update);
                    // return response()->json($otp);
                    // return response()->json('plaese  enter otp');
                    // $otpsuccessmessage = 'I have sent otp please enter otp';
                    // return response()->json($otpsuccessmessage);

                    $otpsuccessmessage = 'I have sent otp please enter otp';

                    return response()->json([
                        'otpsuccessmessage1' => $otpsuccessmessage,
                        'debitid1' => $users->id,
                        'assignmentgenerate_id1' => $users->assignmentgenerate_id,
                        'type1' => $users->type,
                        'status1' => $request->status,
                    ]);
                }
            }
        }
    }



    // public function otpapstore(Request $request)
    // {
    //     // "_token" => "EfrydF0jp8HBpgQeY5NCMiNB45a52NtiFkHwVU7j"
    //     // "otp" => "222"
    //     // "debitid" => "25"
    //     // "assignmentgenerate_id" => "BET100051"
    //     // "type" => "1"

    //     dd($request);
    //     $request->validate([
    //         'otp' => 'required'
    //     ]);

    //     try {

    //         $otp = $request->otp;
    //         $users = DB::table('debtors')->where('id', $request->debitid)->first();
    //         if ($otp == $users->otp) {
    //             // dd($users->otp);
    //             DB::table('debtors')->where('id', $request->debitid)->update([
    //                 'otpverifydate' => date('Y-m-d H:i:s'),
    //             ]);
    //             return view('backEnd.teamconfirm');
    //         } else {
    //             // $output = array('msg' => 'otp did not match! Please enter valid otp');
    //             // return back()->with('statuss', $output);
    //             // return redirect('confirmationauthotp')->with('statuss', $output);

    //             // $otpsuccessmessage = 'otp did not match! Please enter valid otp';
    //             // return response()->json([
    //             //     'otpwarningmessage' => $otpsuccessmessage,
    //             // ]);
    //             return redirect()->back()->with('success_message', 'otp did not match!.');
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    public function otpapstore(Request $request)
    {
        // "_token" => "EfrydF0jp8HBpgQeY5NCMiNB45a52NtiFkHwVU7j"
        // "otp" => "222"
        // "debitid" => "25"
        // "assignmentgenerate_id" => "BET100051"
        // "type" => "1"

        // dd($request);
        // $request->validate([
        //     'otp' => 'required'
        // ]);

        try {
            if ($request->status == 1) {
                // dd('accept');
                $otp = $request->otp;
                $users = DB::table('debtors')->where('id', $request->debitid)->first();

                if ($request->status == $users->status || $users->status == 0) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {
                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('id', $request->debitid)->update([
                            'status'         => $request->status,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                            'updated_at'         =>   date("Y-m-d")
                        ]);

                    return view('backEnd.teamconfirm');
                } else {

                    return redirect()->back()->with('success_message', 'otp did not match!.');
                }
            } else {

                //                 #parameters: array:6 [▼
                //   "_token" => "EfrydF0jp8HBpgQeY5NCMiNB45a52NtiFkHwVU7j"
                //   "otp1" => "33333"
                //   "debitid1" => "26"
                //   "assignmentgenerate_id1" => "BET100051"
                //   "type1" => "1"
                //   "status1" => "0"
                // ]
                // dd('refuse');
                // dd($request);
                $otp = $request->otp1;
                $users = DB::table('debtors')->where('id', $request->debitid1)->first();

                if ($request->status1 == $users->status || $users->status == 1) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {
                    // dd($users->otp);
                    // DB::table('debtors')->where('id', $request->debitid1)->update([
                    //     'otpverifydate' => date('Y-m-d H:i:s'),
                    // ]);

                    $debtorconfirm = DB::table('debtorconfirmations')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('debtor_id', $request->debitid1)->first();

                    $clientid = $request->assignmentgenerate_id1;
                    $debtorid = $request->debitid1;
                    $status = $request->status1;

                    return view('backEnd.teamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
                } else {

                    return redirect()->back()->with('success_message', 'otp did not match!.');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }



    public function debtorconfirm(Request $request)
    {
        // Goes to confirmation page 
        if ($request->status == 1) {
            $usermail = DB::table('debtors')->where('id', $request->debtorid)->first();

            if ($request->status == $usermail->status || $usermail->status == 0) {
                return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
            }

            $assignmentDatas = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);

            return view('backEnd.teamconfirm');
        } else {



            $usermail = DB::table('debtors')->where('id', $request->debtorid)->first();
            if ($request->status == $usermail->status || $usermail->status == 1) {
                return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
            }
            // dd('hi2');
            // $assignmentDatas = DB::table('debtors')
            //     ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
            //         'status'         => $request->status,
            //         'updated_at'         =>   date("Y-m-d")
            //     ]);
            // $status = DB::table('debtors')
            //     ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->pluck('type')->first();
            // dd($status);
            $debtorconfirm = DB::table('debtorconfirmations')
                ->where('assignmentgenerate_id', $request->clientid)->where('debtor_id', $request->debtorid)->first();
            $clientid = $request->clientid;
            $debtorid = $request->debtorid;
            $status = $request->status;
            return view('backEnd.teamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::where('id', $id)->first();
        return view('backEnd.template.edit', compact('id', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => "required|string",
            'description' => "required",
        ]);
        try {
            $data = $request->except(['_token']);
            Template::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('template')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
}
