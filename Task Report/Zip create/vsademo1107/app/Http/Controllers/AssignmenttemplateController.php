<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AssignmenttemplateController extends Controller
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
    public function index($assignmentgenerate_id)
    {
	//	dd($assignmentgenerate_id);
         $templateData =Template::where('assignmentgenerate_id',null)
        ->orwhere('assignmentgenerate_id',$assignmentgenerate_id)->get();
        $grouped = $templateData->groupBy('type');
        $templateDatas = $grouped->map(function ($items, $key) {
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
		
        return view('backEnd.assignmenttemplate.index',compact('templateDatas','assignmentgenerate_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($assignmentgenerate_id)
    {
        return view('backEnd.assignmenttemplate.create',compact('assignmentgenerate_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   dd($request);
        $request->validate([
             'title' => "required|string",
           'description' => "required"
       ]);

         try {
             $data=$request->except(['_token']);
             $data['createdby']= auth()->user()->teammember_id;
            Template::Create($data);
             $output = array('msg' => 'Create Successfully');
             return redirect('assignmenttemplate/' . $request->assignmentgenerate_id)->with('success', $output);
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
        $template = Template::where('id',$id)->first();
        return view('backEnd.assignmenttemplate.edit', compact('id', 'template'));
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
            $data=$request->except(['_token']);
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
