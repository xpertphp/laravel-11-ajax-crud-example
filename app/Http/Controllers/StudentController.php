<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
	 * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $data = Student::query();
    
            return Datatables::of($data)
			->addIndexColumn()
			->addColumn('action', function($row){

				   $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showStudent"><i class="fa-regular fa-eye"></i> View</a>';
				   $btn = $btn. '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';

				   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteStudent"><i class="fa-solid fa-trash"></i> Delete</a>';

					return $btn;
			})
			->rawColumns(['action'])
			->make(true);
        }
          
        return view('students');
    }

    /**
     * Store a newly created resource in storage.
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);
          
        Student::updateOrCreate([
			'id' => $request->student_id
		],
		[
			'first_name' => $request->first_name, 
			'last_name' => $request->last_name, 
			'address' => $request->address
		]);        
       
        return response()->json(['success'=>'Student saved successfully.']);
    }

    /**
     * Display the specified resource.
	 * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
	 * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    /**
     * Remove the specified resource from storage.
	 * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        Student::find($id)->delete();
        return response()->json(['success'=>'Student deleted successfully.']);
    }
}
