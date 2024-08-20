<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;

class PromotionandrejoiningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permotionandrejoin()
    {
        if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12) {
            // $teammemberlist = Teammember::where('status', '0')->get();
            $teammembers = DB::table('teammembers')
                ->leftJoin(
                    'teamrolehistory',
                    'teamrolehistory.teammember_id',
                    '=',
                    'teammembers.id',
                )
                ->where('teammembers.status', 1)
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('teammembers.team_member', 'ASC')
                ->get();

            $teamroles = DB::table('roles')
                ->whereNotIn('id', [16, 17, 18, 19, 20])
                ->select('id', 'rolename', 'created_at')
                ->latest()
                ->get();
            return view('backEnd.applyleave.permotionandrejoin', compact('teammembers', 'teamroles'));
        }
        abort(403, ' you have no permission to access this page ');
    }

    public function permotionandrejoinstore(Request $request)
    {

        $checkrole = DB::table('teammembers')
            ->where('id', $request->employeeid)
            ->select('id', 'role_id', 'staffcode', 'staffcodenumber')
            ->first();

        if ($checkrole->role_id != $request->designationtype) {
            if ($checkrole->role_id < $request->designationtype) {

                $role = '';
                if ($request->designationtype == 11) {
                    $role = "super admin";
                } elseif ($request->designationtype == 12) {
                    $role = "admin";
                } elseif ($request->designationtype == 13) {
                    $role = "partner";
                } elseif ($request->designationtype == 14) {
                    $role = "manager";
                } elseif ($request->designationtype == 15) {
                    $role = "staff";
                }
                $output = array('msg' => 'You can not pormote on this post "' . $role . '".');
                return back()->with('statuss', $output);
            }

            $maxStaffcodeTeammembers = DB::table('teammembers')
                ->where('role_id', $request->designationtype)
                ->max('staffcodenumber');

            $maxStaffcodeTeamRoleHistory = DB::table('teamrolehistory')
                ->where('roleid_new', $request->designationtype)
                ->max('new_staffcodenumber');

            $getlateststaffcode = max($maxStaffcodeTeammembers, $maxStaffcodeTeamRoleHistory);


            if ($request->designationtype == 13) {
                if ($getlateststaffcode == null) {
                    $newstaffcode = '10001';
                } else {
                    $newstaffcode = $getlateststaffcode + 1;
                }
                $newstaffcoderesult = 'P' . $newstaffcode;
                $staffcode = $newstaffcode;
            }
            if ($request->designationtype == 14) {
                if ($getlateststaffcode == null) {
                    $newstaffcode = '20001';
                } else {
                    $newstaffcode = $getlateststaffcode + 1;
                }
                $newstaffcoderesult = 'M' . $newstaffcode;
                $staffcode = $newstaffcode;
            }

            DB::table('teammembers')
                ->where('id', $request->employeeid)
                ->update([
                    'role_id' => $request->designationtype,
                    'staffcodenumber' => $staffcode,
                ]);

            DB::table('users')
                ->where('teammember_id', $request->employeeid)
                ->update([
                    'role_id' => $request->designationtype,
                ]);

            DB::table('teamrolehistory')->insert([
                'teammember_id' => $request->employeeid,
                'roleid_old' => $checkrole->role_id,
                'roleid_new' => $request->designationtype,
                'oldstaff_code' =>  $checkrole->staffcode,
                'newstaff_code' => $newstaffcoderesult,
                'old_staffcodenumber' => $checkrole->staffcodenumber,
                'new_staffcodenumber' => $staffcode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $role = '';
            if ($checkrole->role_id == 11) {
                $role = "super admin";
            } elseif ($checkrole->role_id == 12) {
                $role = "admin";
            } elseif ($checkrole->role_id == 13) {
                $role = "partner";
            } elseif ($checkrole->role_id == 14) {
                $role = "manager";
            } elseif ($checkrole->role_id == 15) {
                $role = "staff";
            }
            $output = array('msg' => 'You are already on this post "' . $role . '".');
            return back()->with('statuss', $output);
        }

        $output = array('msg' => 'Pormotion Successfully Done');
        return back()->with('success', $output);
    }
}
