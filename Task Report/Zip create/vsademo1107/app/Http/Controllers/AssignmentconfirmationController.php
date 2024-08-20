<?php

namespace App\Http\Controllers;

use App\Rules\ExcelColumnHeading;
use App\Models\Debtor;
use App\Models\Teammember;
use App\Models\Client;
use App\Models\Template;
use App\Models\Assignmentbudgeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\HeadingRowImport;
use Excel;
use App\imports\Debtorimport;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;

class AssignmentconfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['confirmationAccept', 'confirmationauthotp', 'confirmationConfirmhide', 'otpapstore', 'otpapstore_hide', 'indexview', 'confirmationConfirm']);
    }
    public function updateStatus(Request $request)
    {
        $debtor = Debtor::findOrFail($request->id);
        $debtor->amounthidestatus = $request->status;
        $debtor->save();

        return response()->json(['success' => true]);
    }


    public function entriesedit($id)
    {
        $entrieseditdata = DB::table('debtors')
            ->where('id', $id)
            ->first();
        return view('backEnd.assignmentconfirmation.editentries', compact('id', 'entrieseditdata'));
    }

   public function entriesupdated(Request $request)
    {
        $request->validate([
            'name' => "required",
            'amount' => "required",
            'email' => "required|email",
            'year' => "required",
            'date' => "required"
        ]);
        try {

            $duplicatecheck = DB::table('debtors')
                ->where('id', '!=', $request->id)
                ->where('name', $request->name)
                ->where('email', $request->email)
                ->where('type', $request->type)
                ->first();

			   if ($request->email == $request->secondaryemail) {
                $output = array('msg' => "Primary email and secondary email must not be the same.");
                $request->flash();
                return back()->with('statuss', $output);
            }
			
            if ($duplicatecheck != null) {
                $output = array('msg' => "This data already exists with the name: $duplicatecheck->name and email: $duplicatecheck->email.");
                $request->flash();
                return back()->with('statuss', $output);
            }

            DB::table('debtors')
                ->where('id', $request->id)->update([
                    'unique' =>  $request->unique,
                    'name' =>  $request->name,
                    'entityname' =>  $request->entityname,
                    'amount' =>  $request->amount,
                    'amounthidestatus' =>  $request->showorhide,
                    'email' =>  $request->email,
                    'secondaryemail' =>  $request->secondaryemail,
                    'year' =>  $request->year,
                    // 'date' =>  $request->date,
                    'date' => Carbon::createFromFormat('Y-m-d', $request->date)->format('d/m/Y'),
                    'address' =>  $request->address,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $output = array('msg' => 'Updated Successfull');
            // return back()->with('success', $output);
            return redirect('/assignmentconfirmation/' . $request->assignmentgenerate_id)->with('statusss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    } 

    public function destroy($id)
    {
        try {
            DB::table('debtors')->where('id', $id)->delete();
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    // public function confirmationstatus(Request $request)
    // {
    //     // dd($request);
    //     try {
    //         DB::table('assignmentbudgetings')
    //             ->where('assignmentgenerate_id', $request->assignmentid)->update([
    //                 'balanceconfirmationstatus' =>  $request->status,
    //             ]);
    //         // $output = array('msg' => 'Updated Successfull');
    //         // return back()->with('statusss', $output);
    //         return response()->json(
    //             [
    //                 'success' => true,
    //                 'status' => $request->status,
    //             ]
    //         );
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    public function confirmationstatus(Request $request)
    {
        try {
            if ($request->status == 0) {
                $otp1 = $request->otp1;
                $otp2 = $request->otp2;
                $otp3 = $request->otp3;
                $otp4 = $request->otp4;
                $otp5 = $request->otp5;
                $otp6 = $request->otp6;

                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;
                $users = DB::table('assignmentbudgetings')
                    ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                    ->first();

                if ($otp == $users->balanceconfirmationotp) {

                    DB::table('assignmentbudgetings')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->update([
                            'balanceconfirmationstatus' =>  $request->status,
                        ]);

                    $output = array('msg' => 'Your balance confirmation has been closed.');
                    return back()->with('success', $output);
                } else {
                    // return redirect()->back()->with('success_message', 'OTP did not match!.');
                    $output = array('msg' => 'OTP did not match!');
                    return back()->with('statuss', $output);
                }
            } else {

                $otp1 = $request->otp1;
                $otp2 = $request->otp2;
                $otp3 = $request->otp3;
                $otp4 = $request->otp4;
                $otp5 = $request->otp5;
                $otp6 = $request->otp6;

                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;
                $users = DB::table('assignmentbudgetings')
                    ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                    ->first();

                if ($otp == $users->balanceconfirmationotp) {

                    DB::table('assignmentbudgetings')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->update([
                            'balanceconfirmationstatus' =>  $request->status,
                        ]);

                    $output = array('msg' => 'Your balance confirmation has been opened.');
                    return back()->with('success', $output);
                } else {
                    // return redirect()->back()->with('success_message', 'OTP did not match!.');
                    $output = array('msg' => 'OTP did not match!');
                    return back()->with('statuss', $output);
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


    public function acceptstatus(Request $request)
    {
        try {
            // Log the request data for debugging
            Log::info('Request Data:', $request->all());

            DB::table('debtors')
                ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                ->where('id', $request->debitid)
                ->update([
                    'status' => $request->status,
                    'updated_at' => date("Y-m-d")
                ]);

            $debtorconfirm = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                ->where('id', $request->debitid)
                ->first();

            $fileName = '';
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $destinationPath = 'backEnd/image/confirmationfile';
                $fileName = $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
            }

            DB::table('debtorconfirmations')->insert([
                'debtor_id' => $request->debitid,
                'assignmentgenerate_id' => $request->assignmentgenerate_id,
                'remark' => null,
                'amount' => null,
                'file' => $fileName,
                'name' => $debtorconfirm->name,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d")
            ]);

            $output = ['msg' => 'Your balance confirmation has been closed.'];
            return response()->json($output, 200); // Return JSON response
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return response()->json($output, 500); // Return JSON response with error status
        }
    }



    // public function confirmationotpsend(Request $request)
    // {
    //     $assignment = DB::table('assignmentmappings')
    //         ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentid)
    //         ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //         ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //         ->select('assignmentmappings.*', 'assignmentbudgetings.status', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
    //         ->first();

    //     $teammembers = DB::table('teammembers')
    //         ->where('id', $assignment->leadpartner)
    //         ->select('team_member', 'emailid',)
    //         ->first();


    //     $otp = sprintf("%06d", mt_rand(1, 999999));
    //     DB::table('assignmentbudgetings')
    //         ->where('assignmentgenerate_id', $request->assignmentid)->update([
    //             'balanceconfirmationotp'  => $otp,
    //         ]);


    //     $data = array(
    //         'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
    //         'assignmentname' => $assignment->assignmentname,
    //         'client_name' => $assignment->client_name,
    //         'client_code' => $assignment->client_code,
    //         'email' => $teammembers->emailid,
    //         'otp' => $otp,
    //         'name' => $teammembers->team_member,
    //     );



    //     Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
    //         $msg->to($data['email']);
    //         $msg->subject('Balance Confirmation Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
    //     });

    //     $otpsuccessmessage = 'We have sent otp on mail please enter otp';
    //     return response()->json([
    //         'otpsuccessmessage' => $otpsuccessmessage,
    //     ]);
    // }

    // public function confirmationotpsend(Request $request)
    // {
    //     // dd($request);
    //     $assignment = DB::table('assignmentmappings')
    //         ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentid)
    //         ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //         ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //         ->select('assignmentmappings.*', 'assignmentbudgetings.balanceconfirmationstatus', 'assignmentbudgetings.status', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
    //         ->first();

    //     $teammembers = DB::table('teammembers')
    //         ->where('id', $assignment->leadpartner)
    //         ->select('team_member', 'emailid',)
    //         ->first();

    //     // dd($assignment->balanceconfirmationstatus);
    //     // // closed balance confirm
    //     if ($request->status == 0) {

    //         if ($assignment->status == 0) {
    //             $otpsuccessmessage = 'Your assignment is closed, so you cannot close the balance confirmation';
    //             return response()->json([
    //                 'otpsuccessmessage' => $otpsuccessmessage,
    //                 'status' => 1,
    //             ]);
    //         }

    //         if ($assignment->balanceconfirmationstatus == 0) {
    //             $otpsuccessmessage = 'Your balance confirmation is already close.';
    //             return response()->json([
    //                 'otpsuccessmessage' => $otpsuccessmessage,
    //                 'status' => 1,
    //             ]);
    //         }

    //         $otp = sprintf("%06d", mt_rand(1, 999999));
    //         DB::table('assignmentbudgetings')
    //             ->where('assignmentgenerate_id', $request->assignmentid)->update([
    //                 'balanceconfirmationotp'  => $otp,
    //             ]);

    //         $data = array(
    //             'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
    //             'assignmentname' => $assignment->assignmentname,
    //             'client_name' => $assignment->client_name,
    //             'client_code' => $assignment->client_code,
    //             'email' => $teammembers->emailid,
    //             'otp' => $otp,
    //             'name' => $teammembers->team_member,
    //             'status' => $request->status,
    //         );

    //         Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
    //             $msg->to($data['email']);
    //             $msg->subject('Balance Confirmation Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
    //         });

    //         $otpsuccessmessage = 'We have sent otp on mail to close the balance confirmation';
    //         return response()->json([
    //             'otpsuccessmessage' => $otpsuccessmessage,
    //             'status' => $request->status,
    //         ]);
    //     }
    //     // open balance confirm
    //     else {

    //         if ($assignment->status == 0) {
    //             $otpsuccessmessage = 'Your assignment is closed, so you cannot close the balance confirmation';
    //             return response()->json([
    //                 'otpsuccessmessage' => $otpsuccessmessage,
    //                 'status' => 0,
    //             ]);
    //         }
    //         if ($assignment->balanceconfirmationstatus == 1) {
    //             $otpsuccessmessage = 'Your balance confirmation is already open.';
    //             return response()->json([
    //                 'otpsuccessmessage' => $otpsuccessmessage,
    //                 'status' => 0,
    //             ]);
    //         }
    //         $otp = sprintf("%06d", mt_rand(1, 999999));
    //         DB::table('assignmentbudgetings')
    //             ->where('assignmentgenerate_id', $request->assignmentid)->update([
    //                 'balanceconfirmationotp'  => $otp,
    //             ]);

    //         $data = array(
    //             'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
    //             'assignmentname' => $assignment->assignmentname,
    //             'client_name' => $assignment->client_name,
    //             'client_code' => $assignment->client_code,
    //             'email' => $teammembers->emailid,
    //             'otp' => $otp,
    //             'name' => $teammembers->team_member,
    //             'status' => $request->status,
    //         );

    //         Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
    //             $msg->to($data['email']);
    //             $msg->subject('Balance Confirmation Opend by OTP' . ' || ' . $assignment->assignmentgenerate_id);
    //         });

    //         $otpsuccessmessage = 'We have sent otp on mail to open the balance confirmation';
    //         return response()->json([
    //             'otpsuccessmessage' => $otpsuccessmessage,
    //             'status' => $request->status,
    //         ]);
    //     }
    // }

    public function confirmationotpsend(Request $request)
    {
        // dd($request);
        $assignment = DB::table('assignmentmappings')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentid)
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->select('assignmentmappings.*', 'assignmentbudgetings.balanceconfirmationstatus', 'assignmentbudgetings.status', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
            ->first();

        $teammembers = DB::table('teammembers')
            ->where('id', $assignment->leadpartner)
            ->select('team_member', 'emailid',)
            ->first();

        // dd($assignment->balanceconfirmationstatus);
        // // closed balance confirm
        if ($request->status == 0) {

            if ($assignment->status == 0) {
                $otpsuccessmessage = 'Your assignment is closed, so you cannot close the balance confirmation';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 1,
                ]);
            }

            if ($assignment->balanceconfirmationstatus == 0) {
                $otpsuccessmessage = 'Your balance confirmation is already close.';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 1,
                ]);
            }

            $otp = sprintf("%06d", mt_rand(1, 999999));
            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $request->assignmentid)->update([
                    'balanceconfirmationotp'  => $otp,
                ]);

            $data = array(
                'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                'assignmentname' => $assignment->assignmentname,
                'client_name' => $assignment->client_name,
                'client_code' => $assignment->client_code,
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
                'status' => $request->status,
            );

            Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
                $msg->to($data['email']);
                $msg->subject('Balance Confirmation Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
            });

            $otpsuccessmessage = 'We have sent otp on mail to close the balance confirmation';
            return response()->json([
                'otpsuccessmessage' => $otpsuccessmessage,
                'status' => $request->status,
            ]);
        }
        // open balance confirm
        else {

            if ($assignment->status == 0) {
                $otpsuccessmessage = 'Your assignment is closed, so you cannot open the balance confirmation';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 0,
                ]);
            }
            if ($assignment->balanceconfirmationstatus == 1) {
                $otpsuccessmessage = 'Your balance confirmation is already open.';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 0,
                ]);
            }
            $otp = sprintf("%06d", mt_rand(1, 999999));
            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $request->assignmentid)->update([
                    'balanceconfirmationotp'  => $otp,
                ]);

            $data = array(
                'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                'assignmentname' => $assignment->assignmentname,
                'client_name' => $assignment->client_name,
                'client_code' => $assignment->client_code,
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
                'status' => $request->status,
            );

            Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
                $msg->to($data['email']);
                $msg->subject('Balance Confirmation Opend by OTP' . ' || ' . $assignment->assignmentgenerate_id);
            });

            $otpsuccessmessage = 'We have sent otp on mail to open the balance confirmation';
            return response()->json([
                'otpsuccessmessage' => $otpsuccessmessage,
                'status' => $request->status,
            ]);
        }
    }


    public function otpapstore_hide(Request $request)
    {
        try {
            if ($request->status == 1) {

                $otp1 = $request->otp1;
                $otp2 = $request->otp2;
                $otp3 = $request->otp3;
                $otp4 = $request->otp4;
                $otp5 = $request->otp5;
                $otp6 = $request->otp6;

                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //  $otp = $request->otp;
                $users = DB::table('debtors')->where('id', $request->debitid)->first();

                if ($request->status == $users->status || $users->status == 1) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {

                    $debtorconfirm = DB::table('debtorconfirmations')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('debtor_id', $request->debitid)->first();

                    $clientid = $request->assignmentgenerate_id;
                    $debtorid = $request->debitid;
                    $status = $request->status;

                    return view('backEnd.assignmentteamrejecthide', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
                } else {

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
                }
            } else {
                $otp1 = $request->otp11;
                $otp2 = $request->otp12;
                $otp3 = $request->otp13;
                $otp4 = $request->otp14;
                $otp5 = $request->otp15;
                $otp6 = $request->otp16;


                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //      $otp = $request->otp1;
                $users = DB::table('debtors')->where('id', $request->debitid1)->first();

                if ($request->status1 == $users->status || $users->status == 0) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {
                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('id', $request->debitid1)->update([
                            'status'         => $request->status1,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                            'updated_at'         =>   date("Y-m-d")
                        ]);

                    return view('backEnd.teamconfirm');
                } else {

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
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
    public function confirmationConfirmhide(Request $request)
    {
        //dd($request);
        $request->validate([
            'amount' => "required",
            // 'remark' => "required|string"
        ]);

        try {
            $debtorconfirm = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->first();
            // dd($debtorconfirm);
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $destinationPath = 'backEnd/image/confirmationfile';
                $name = $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                $data['file'] = $name;
            }
            DB::table('debtorconfirmations')->insert([
                'debtor_id'         => $request->debtorid,
                'assignmentgenerate_id' => $request->clientid,
                'remark'         => $request->remark,
                'amount'         => $request->amount,
                'file'         =>  $data['file'] ?? '',
                'name'         =>  $debtorconfirm->name,
                'created_at'         =>   date("Y-m-d"),
                'updated_at'         =>   date("Y-m-d")
            ]);

            $assignmentDatas = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);
            // $output = array('msg' => 'Submit Successfully');
            // return back()->with('success', $output);
            return view('backEnd.teamconfirm');
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function confirmationConfirm(Request $request)
    {
        // dd($request);
        $request->validate([
            'amount' => "required",
            // 'remark' => "required|string"
        ]);

        try {
            $debtorconfirm = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->first();
            //     dd($debtorconfirm);
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $destinationPath = 'backEnd/image/confirmationfile';
                $name = $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                $data['file'] = $name;
            }
            DB::table('debtorconfirmations')->insert([
                'debtor_id'         => $request->debtorid,
                'assignmentgenerate_id' => $request->clientid,
                'remark'         => $request->remark,
                'amount'         => $request->amount,
                'file'         =>  $data['file'] ?? '',
                'name'         =>  $debtorconfirm->name,
                'created_at'         =>   date("Y-m-d"),
                'updated_at'         =>   date("Y-m-d")
            ]);

            $assignmentDatas = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);
            // $output = array('msg' => 'Submit Successfully');
            // return back()->with('success', $output);
            // return view('backEnd.teamconfirm');
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    // public function indexview($assignmentgenerate_id)
    // {
    //     $teammember = Teammember::where('status', '1')->whereIn('role_id', [15, 14, 13])->with('title', 'role')->get();
    //     $clientList =  Assignmentbudgeting::where('assignmentgenerate_id', $assignmentgenerate_id)->first();

    //     $clientdebit =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 1)->get();
    //     //dd($clientdebit);
    //     $clientcredit  =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 2)->get();
    //     $clientbank =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 3)->get();
    //     $templateData = Template::where('assignmentgenerate_id', null)
    //         ->orwhere('assignmentgenerate_id', $assignmentgenerate_id)->get();
    //     $grouped = $templateData->groupBy('type');
    //     $template = $grouped->map(function ($items, $key) {
    //         // Check if there are multiple items of the same type
    //         if ($items->count() > 1) {
    //             // Prefer items with a non-null 'assignmentgenerate_id' or take the most recently updated one
    //             $filteredItems = $items->filter(function ($item) {
    //                 return !is_null($item->assignmentgenerate_id);
    //             });

    //             // If no items with 'assignmentgenerate_id', revert to the latest by 'updated_at'
    //             return $filteredItems->count() > 0 ? $filteredItems : $items->sortByDesc('updated_at')->take(1);
    //         } else {
    //             return $items;
    //         }
    //     })->collapse();

    //     return view('backEnd.assignmentconfirmation.index', compact('template', 'clientdebit', 'teammember', 'clientcredit', 'clientbank', 'clientList', 'assignmentgenerate_id'));
    // }

    public function indexview($assignmentgenerate_id)
    {
        // dd($assignmentgenerate_id);
        $teammember = Teammember::where('status', '1')->whereIn('role_id', [15, 14, 13])->with('title', 'role')->get();
        $clientList =  Assignmentbudgeting::where('assignmentgenerate_id', $assignmentgenerate_id)->first();

        $clientdebit =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 1)->get();
        //dd($clientdebit);
        $clientcredit  =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 2)->get();
        $clientbank =  Debtor::with('debtorconfirm', 'debtorcreatedby')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 3)->get();
        $templateData = Template::where('assignmentgenerate_id', null)
            ->orwhere('assignmentgenerate_id', $assignmentgenerate_id)->get();
        $grouped = $templateData->groupBy('type');
        $autoreminder = DB::table('confirmationrem')
            ->where('assignmentgenid', $assignmentgenerate_id)
            ->first();
        // dd($autoreminder);

        $template = $grouped->map(function ($items, $key) {
            // Check if there are multiple items of the same type
            if ($items->count() > 1) {
                // Prefer items with a non-null 'assignmentgenerate_id' or take the most recently updated one
                $filteredItems = $items->filter(function ($item) {
                    return !is_null($item->assignmentgenerate_id);
                });

                // If no items with 'assignmentgenerate_id', revert to the latest by 'updated_at'
                return $filteredItems->count() > 0 ? $filteredItems : $items->sortByDesc('updated_at')->take(1);
            } else {
                return $items;
            }
        })->collapse();

        return view('backEnd.assignmentconfirmation.index', compact('template', 'clientdebit', 'teammember', 'clientcredit', 'clientbank', 'clientList', 'assignmentgenerate_id', 'autoreminder'));
    }

    public function autoreminder(Request $request)
    {
        $request->validate([
            'noofdays' => "required",
            'maxremider' => "required",

        ]);

        DB::table('confirmationrem')->insert([
            'noofdays'         => $request->noofdays,
            'assignmentgenid'  => $request->assignmentgenerate_id,
            'created_by' => auth()->user()->teammember_id,
            'max_rem' => $request->maxremider,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // $actionName = class_basename($request->route()->getActionname());
        // $urlname = substr($actionName, 0, strpos($actionName, "Controller"));
        // $id = auth()->user()->teammember_id;
        // DB::table('balanceconfirmlogs')->insert([
        //     'team_id' => $id,
        //     // 'ip_address' => $request->ip(),
        //     'activitytitle' => $urlname,
        //     'description' => 'Auto reminder set on' . $request->assignmentgenerate_id,
        //     'created_at' => date('y-m-d'),
        //     'updated_at' => date('y-m-d')
        // ]);

        $output = array('msg' => 'Auto Reminder Set Successfully');
        return back()->with('statusss', $output);
    }


    public function autoreminderdestroy($id)
    {

        try {
            DB::table('confirmationrem')->where('id', $id)->delete();
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function debtorExcel(Request $request)
    {
        // Validate the uploaded file

        // $request->validate([
        //     'file' => ['required', 'file', new ExcelColumnHeading(['unique', 'name', 'amount', 'email', 'date', 'year', 'address'])],
        // ]);
        $request->validate([
            'file' => ['required', 'file', new ExcelColumnHeading(['unique', 'name', 'amount', 'primary email', 'secondary email', 'date', 'year', 'address', 'entity name', 'show or hide'])],
        ]);

        try {


            $file = $request->file('file');
            $data = Excel::toArray(new DebtorImport, $file);

            $skippedBecauseEmpty = false;
            $skippedBecauseInvalidEmail = false;
            $skippedBecauseDuplicate = false;
            $rowsInserted = 0; // Track the number of inserted rows

            foreach ($data[0] as $value) {
                // Check for empty required fields and skip the row if any are empty
                if (empty($value['name']) || empty($value['amount']) || empty($value['primary_email']) || empty($value['date']) || empty($value['year']) || empty($value['address'])) {
                    $skippedBecauseEmpty = true;
                    continue;
                }

                // Check for valid email format
                if (!filter_var($value['primary_email'], FILTER_VALIDATE_EMAIL)) {
                    $skippedBecauseInvalidEmail = true;
                    continue;
                }
				       if (!empty($value['primary_email']) && !empty($value['secondary_email'])) {
                    if ($value['primary_email'] == $value['secondary_email']) {
                      $value['secondary_email'] = '';
						//    $skippedBecauseEmpty = true;
                      //  continue;
                    }
                }

                // Convert Excel serial date to Unix timestamp
                $unixTimestamp = ($value['date'] - 25569) * 86400;

                // Check database for existing debtor with the same email, name, amount, assignmentgenerate_id, and type
                $exists = Debtor::where('email', $value['primary_email'])
                    ->where('name', $value['name'])
                    ->where('amount', $value['amount'])
                    ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                    ->where('type', $request->type)
                    ->exists();
                if ($exists) {
                    $skippedBecauseDuplicate = true;
                    continue; // Skip this row as it's a duplicate
                }

                if (trim($value['show_or_hide']) == 'hide' || trim($value['show_or_hide']) == 'Hide') {
                    $status = 0;
                } else {
                    $status = 1;
                }

                // Prepare the database entry array
                $db = [
                    'unique' => $value['unique'],
                    'name' => $value['name'],
                    'amount' => $value['amount'],
                    'date' => date('d/m/Y', $unixTimestamp),
                    'year' => $value['year'],
                    'address' => $value['address'],
                    'email' => $value['primary_email'],
                    'entityname' => $value['entity_name'],
                    'secondaryemail' => $value['secondary_email'],
                    // 'showorhide' => $status,
                    'amounthidestatus' => $status,
                    'assignmentgenerate_id' => $request->assignmentgenerate_id,
                    'type' => $request->type,
                    'created_by' => auth()->user()->teammember_id,
                ];

                // Create the debtor record in the database
                Debtor::create($db);
                $rowsInserted++; // Increment the counter for successful inserts
            }

            // Construct success message based on skipped and inserted rows
            $message = $rowsInserted > 0 ? 'Excel file uploaded successfully! ' : '';
            if ($skippedBecauseEmpty || $skippedBecauseInvalidEmail || $skippedBecauseDuplicate) {
                $message .= 'Invalid or duplicate entries will not be uploaded.';
            }

            $output = ['msg' => $message];
            return back()->with('statusss', $output);
        } catch (Exception $e) {
            // Log and handle exceptions
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return back()->withErrors($output)->withInput();
        }
    }



    public function view($id)
    {
        $debtorconfirmation = DB::table('debtorconfirmations')->where('debtor_id', $id)->get();
        return view('backEnd.assignmentconfirmation.view', compact('debtorconfirmation'));
    }
    public function template(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->template_id)) {

                $client = DB::table('templates')->where('id', $request->template_id)->first();

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
        $request->validate([
            'description' => "required",
        ]);
        try {

            $data = $request->except(['_token']);

            $confirmationIds = $request->input('confirmationid', []);

            // Filter out all null values from the array
            $nonNullConfirmationIds = array_filter($confirmationIds, function ($value) {
                return !is_null($value);
            });

            // Check if the filtered array is empty
            if (empty($nonNullConfirmationIds)) {
                $output = array('msg' => 'Select at least one check box to proceed.');
                return back()->with('statuss', $output);
            }
            //die;
            $debtor = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('type', $request->type)
                ->where('mailstatus', 0)
                ->whereIn('id', explode(", ", $request->confirmationid[0]))->get();

            // dd($debtor);
            //    die;
            if ($debtor->isEmpty()) {
                $output = array('msg' => 'Prior to proceeding, it is necessary to first upload the Excel data');
                return back()->with('statuss', $output);
            }



            $draftcheck = DB::table('templates')->where('id', $request->templateid)->first()->draftstatus;
            // dd($draftcheck == 0);
            if ($draftcheck == 0) {
                $output = array('msg' => 'Mail draft is pending please save your draft');
                return back()->with('statuss', $output);
            }

            foreach ($debtor as $debtors) {
                // dd($debtors);
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                $des = $request->description;
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]", "[entityname]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address", "$debtors->entityname"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
                    'name' =>  $debtors->name,
                    'email' =>  $debtors->email,
                    'secondaryemail' =>  $debtors->secondaryemail ?? '',
                    'year' =>  $debtors->year,
                    'date' =>  $debtors->date,
                    'amount' =>  $debtors->amount,
                    'entityname' =>  $debtors->entityname,
                    'clientid' => $debtors->assignmentgenerate_id,
                    'debtorid' => $debtors->id,
                    'amounthidestatus' => $debtors->amounthidestatus,
                    'type' => $debtors->type,
                    'description' => $description,
                    'teammembermail' => $teammembermail ?? '',
                    'yes' => 1,
                    'no' => 0
                );

                try {
                    $mailarray = array_filter([$data['email'], $data['secondaryemail']]);
                    foreach ($mailarray as $email) {
                        Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request, $email) {
                            $msg->to($email);
                            $msg->subject($data['subject']);
                            if ($request->teammember_id) {
                                $msg->cc($data['teammembermail']);
                            }
                            // Add CC for additional emails from the input field
                            if ($request->ccmail) {
                                $assignEmails = explode(',', $request->ccmail);
                                foreach ($assignEmails as $email) {
                                    $msg->cc(trim($email));
                                }
                            }
                        });
                    }
                    // dd('hi');

                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
                        ->where('id', $debtors->id)
                        ->update([
                            'mailstatus' => 1,
                            'status' => 3,
                            'autoreminddate' => now(),
                            'updated_at' => now()
                        ]);
                } catch (Exception $e) {
                    // Log the error or handle it as needed
                    // For example, you can log the exception to laravel.log
                    // or you can notify the administrator about the failure
                    \Log::error('Mail sending failed: ' . $e->getMessage());

                    // Update mailstatus to 0 in the database
                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
                        ->where('id', $debtors->id)
                        ->update([
                            'mailstatus' => 0,
                            'updated_at' => now()
                        ]);
                }
            }
            $output = array('msg' => 'Email Sent Successfully');
            return back()->with('statusss', $output);
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
            $checkmail = DB::table('balanceconfirmationreminder')
                ->where('debtorsid', $id)
                ->latest()
                ->first();

            if ($checkmail === null || $checkmail->reminderdatecount != date('Y-m-d')) {
                $this->sendEmail($usermail);
                $output = ['msg' => 'A mail reminder has been sent.'];
                return back()->with('statusss', $output);
            } else {
                $output = ['msg' => 'Only one reminder can be sent Today'];
                return back()->with('statusss', $output);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return back()->withErrors($output)->withInput();
        }
    }

    public function sendEmail($usermail)
    {
        $maildatas = DB::table('templates')->where('assignmentgenerate_id', $usermail->assignmentgenerate_id)
            ->where('type', $usermail->type)->first();
        if ($maildatas ==  null) {
            $maildata =  DB::table('templates')->where('type', $usermail->type)->first();
        } else {
            $maildata = DB::table('templates')->where('assignmentgenerate_id', $usermail->assignmentgenerate_id)
                ->where('type', $usermail->type)->first();
        }
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
            'amounthidestatus' => $usermail->amounthidestatus,
            'type' => $usermail->type,
            'description' => $description,
            'yes' => 1,
            'no' => 0
        );
        Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data) {
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
        $templatetype = $request->type;
        // $template = DB::table('templates')->where('type', $templatetype)->first();
        $maildatas = DB::table('templates')->where('assignmentgenerate_id', $clientid)
            ->where('type', $templatetype)->first();
        if ($maildatas ==  null) {
            $template =  DB::table('templates')->where('type', $templatetype)->first();
        } else {
            $template = DB::table('templates')->where('assignmentgenerate_id', $clientid)
                ->where('type', $templatetype)->first();
        }

        $debtors = DB::table('debtors')
            ->where('id', $debtorid)->where('type', $request->type)
            ->first();
        $des = $template->description;
        $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]", "[entityname]"];
        $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address", "$debtors->entityname"];
        $description = str_replace($healthy, $yummy, $des);

        $confirmation = DB::table('debtors')->where('id', $debtorid)->first();
        if ($confirmation->amounthidestatus == 1) {
            return view('backEnd.assignmentconfirmationaccept', compact('clientid', 'debtorid', 'yes', 'no', 'debtors', 'description'));
        } else {
            return view('backEnd.assignmentconfirmationamounthide', compact('clientid', 'debtorid', 'yes', 'no', 'debtors', 'description'));
        }
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
            if (in_array($request->templateid, [1, 2, 3])) {
                $template_name =  DB::table('templates')->where('id', $request->templateid)
                    ->where('assignmentgenerate_id', null)->first();
                DB::table('templates')->insert([
                    'draftstatus' => 0,
                    'title' => $template_name->title,
                    'createdby' => auth()->user()->teammember_id,
                    'assignmentgenerate_id' => $request->assignmentgenerate_id,
                    'type' => $template_name->type,
                    'description' => $request->description,
                    'created_at'                =>       date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
            } else {
                $savedraft = DB::table('templates')
                    ->where('id', $request->templateid)
                    ->update([
                        'description' => $request->description,
                        'draftstatus' => 0,
                    ]);
            }

            $output = array('msg' => 'Mail saved as a Draft');
            return back()->with('statusss', $output);
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
        $request->validate([
            'type' => "required",
        ]);

        try {
            if (in_array($request->templateid, [1, 2, 3])) {
                $template_name =  DB::table('templates')->where('id', $request->templateid)
                    ->where('assignmentgenerate_id', null)->first();
                DB::table('templates')->insert([
                    'draftstatus' => 1,
                    'title' => $template_name->title,
                    'createdby' => auth()->user()->teammember_id,
                    'assignmentgenerate_id' => $request->assignmentgenerate_id,
                    'type' => $template_name->type,
                    'description' => $request->description,
                    'created_at'                =>       date('Y-m-d H:i:s'),
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
            } else {
                $savedraft = DB::table('templates')
                    ->where('id', $request->templateid)
                    ->update([
                        'draftstatus' => 1,
                        'description' => $request->description,
                    ]);
            }



            $output = array('msg' => 'Mail saved successfully');
            return back()->with('statusss', $output);
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
            ->get();
        // dd($timesheetrequestreminderlist);

        return response()->json([
            'balanceconfirmationreminderlist' => $balanceconfirmationreminderlist,
        ]);
    }


    public function confirmationauthotp(Request $request)
    {


        if ($request->ajax()) {
            if (isset($request->id)) {
                if ($request->status == 1) {

                    $users = DB::table('debtors')->where('id', $request->id)->first();
                    //  dd($users);
                    if ($request->status == $users->status || $users->status == 0) {
                        $otpsuccessmessage = 'You have already Submitted';
                        return response()->json([
                            'otpsuccessmessage2' => $otpsuccessmessage,
                        ]);
                    }

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

                    $otpsuccessmessage = 'We have sent OTP on mail please enter OTP';
                    return response()->json([
                        'otpsuccessmessage' => $otpsuccessmessage,
                        'debitid' => $users->id,
                        'assignmentgenerate_id' => $users->assignmentgenerate_id,
                        'type' => $users->type,
                        'status' => $request->status,
                    ]);
                } else {

                    $users = DB::table('debtors')->where('id', $request->id)->first();

                    if ($request->status1 == $users->status || $users->status == 1) {
                        $otpsuccessmessage = 'You have already Submitted';
                        return response()->json([
                            'otpsuccessmessage3' => $otpsuccessmessage,
                        ]);
                    }

                    $otp = sprintf("%06d", mt_rand(1, 999999));
                    $data = array(
                        'email' =>  $users->email,
                        'otp' =>  $otp,
                    );

                    Mail::send('emails.balanceconfirmotp', $data, function ($msg) use ($data) {
                        $msg->to($data['email']);
                        $msg->subject('VSA Balance Confirmation refuse OTP');
                    });
                    $update = DB::table('debtors')
                        ->where('id', $request->id)->update([
                            'otp' =>  $otp,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                        ]);

                    $otpsuccessmessage = 'We have sent OTP on mail please enter OTP';

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

    public function otpapstore(Request $request)
    {
        try {
            if ($request->status == 1) {
                $otp1 = $request->otp1;
                $otp2 = $request->otp2;
                $otp3 = $request->otp3;
                $otp4 = $request->otp4;
                $otp5 = $request->otp5;
                $otp6 = $request->otp6;

                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //   $otp = $request->otp;
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

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
                }
            } else {
                $otp1 = $request->otp11;
                $otp2 = $request->otp12;
                $otp3 = $request->otp13;
                $otp4 = $request->otp14;
                $otp5 = $request->otp15;
                $otp6 = $request->otp16;


                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //$otp = $request->otp1;
                $users = DB::table('debtors')->where('id', $request->debitid1)->first();

                if ($request->status1 == $users->status || $users->status == 1) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {

                    $debtorconfirm = DB::table('debtorconfirmations')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('debtor_id', $request->debitid1)->first();

                    $clientid = $request->assignmentgenerate_id1;
                    $debtorid = $request->debitid1;
                    $status = $request->status1;

                    return view('backEnd.assignmentteamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
                } else {

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
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

    // public function otpskipconfirmation(Request $request)
    // {
    //     dd($request->status);
    //     try {
    //         if ($request->status == 1) {
    //             $users = DB::table('debtors')->where('id', $request->debitid)->first();
    //             if ($request->status == $users->status || $users->status == 0) {
    //                 return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
    //             }

    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('id', $request->debitid)->update([
    //                     'status'         => $request->status,
    //                     'updated_at'         =>   date("Y-m-d")
    //                 ]);
    //             return view('backEnd.teamconfirm');
    //         } else {

    //             $users = DB::table('debtors')->where('id', $request->debitid1)->first();

    //             if ($request->status1 == $users->status || $users->status == 1) {
    //                 return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
    //             }

    //             $debtorconfirm = DB::table('debtorconfirmations')
    //                 ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('debtor_id', $request->debitid1)->first();

    //             $clientid = $request->assignmentgenerate_id1;
    //             $debtorid = $request->debitid1;
    //             $status = $request->status1;
    //             return view('backEnd.assignmentteamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }





    // public function otpskipconfirmation(Request $request)
    // {
    //     $status = $request->status;
    //     $debitid = $request->debitid;
    //     $assignmentgenerate_id = $request->assignmentgenerate_id;

    //     if ($status == 1) {
    //         $user = DB::table('debtors')->where('id', $debitid)->first();

    //         if ($user->status == 1 || $user->status == 0) {
    //             return response()->json(['error' => 'You have already submitted'], 400);
    //         }

    //         DB::table('debtors')
    //             ->where('assignmentgenerate_id', $assignmentgenerate_id)
    //             ->where('id', $debitid)
    //             ->update([
    //                 'status' => $status,
    //                 'updated_at' => now()
    //             ]);

    //         return response()->json(['success' => true]);
    //     } elseif ($status == 0) {
    //         // Handle the refusal case if needed.
    //         return redirect()->back()->with('message', 'Refusal recorded.');
    //     }

    //     return response()->json(['error' => 'Invalid status'], 400);
    // }


    // public function otpskipconfirmation(Request $request)
    // {
    //     $status = $request->status;
    //     $debitid = $request->debitid;
    //     $assignmentgenerate_id = $request->assignmentgenerate_id;

    //     if ($status == 1) {
    //         $user = DB::table('debtors')->where('id', $debitid)->first();

    //         if ($user->status == 1 || $user->status == 0) {
    //             return response()->json(['error' => 'You have already submitted'], 400);
    //         }

    //         DB::table('debtors')
    //             ->where('assignmentgenerate_id', $assignmentgenerate_id)
    //             ->where('id', $debitid)
    //             ->update([
    //                 'status' => $status,
    //                 'updated_at' => now()
    //             ]);

    //         return response()->json(['success' => true]);
    //     } elseif ($status == 0) {
    //         // Handle the refusal case if needed.
    //         return redirect()->back()->with('message', 'Refusal recorded.');
    //     }

    //     return response()->json(['error' => 'Invalid status'], 400);
    // }


    public function otpskipconfirmation(Request $request)
    {
        try {
            // dd($request);
            if ($request->status == 1) {
                $users = DB::table('debtors')->where('id', $request->debitid)->first();
                $checkbalanceconfirm = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignmentgenerate_id)->first();
                if ($request->status == $users->status || $users->status == 0) {
                    return response()->json(['error' => 'You have already submitted'], 400);
                }

                if ($checkbalanceconfirm->balanceconfirmationstatus == 0) {
                    return response()->json(['error' => 'The link has been expired'], 400);
                }

                return response()->json(['success' => true]);
            } else {

                $users = DB::table('debtors')->where('id', $request->debitid1)->first();
                $checkbalanceconfirm = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->first();

                if ($request->status1 == $users->status || $users->status == 1) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($checkbalanceconfirm->balanceconfirmationstatus == 0) {
                    return back()->withErrors(['error' => 'The link has been expired'])->withInput();
                }

                $debtorconfirm = DB::table('debtorconfirmations')
                    ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('debtor_id', $request->debitid1)->first();

                $clientid = $request->assignmentgenerate_id1;
                $debtorid = $request->debitid1;
                $status = $request->status1;

                return view('backEnd.assignmentteamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
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
}
