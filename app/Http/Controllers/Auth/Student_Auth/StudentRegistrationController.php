<?php

namespace App\Http\Controllers\Auth\Student_Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\studentsManagement_Model;
use App\Models\User;


class StudentRegistrationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = studentsManagement_Model::all();
        return view('auth.students.studentRegistration', compact('student'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required','regex:/^[0-9]{2}-[0-9]{6}$/','unique:db_students,id'],
            'sid' => ['required','unique:db_students,sid'],
            'lname' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:db_students,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/'
            ],
        ]);
    }

    /**
     * Create a new student instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\studentsManagementModel
     */
    protected function create(array $data)
    {
        // Combine names for fullname
        $fullname = trim($data['fname'] . ' ' . ($data['mname'] ?? '') . ' ' . $data['lname']);
        $fullname = preg_replace('/\s+/', ' ', $fullname); // Remove extra spaces

        return studentsManagementModel::create([
            'id' => $data['id'],
            'sid' => $data['sid'],
            'lname' => $data['lname'],
            'fname' => $data['fname'],
            'mname' => $data['mname'] ?? null,
            'fullname' => $fullname,
            'age' => $data['age'] ?? null,
            'sex' => $data['sex'] ?? null,
            'address' => $data['address'] ?? null,
            'area_code' => $data['area_code'] ?? null,
            'college_code' => $data['college_code'] ?? null,
            'course_code' => $data['course_code'] ?? null,
            'year_level' => $data['year_level'] ?? null,
            'term' => $data['term'] ?? null,
            'sy' => $data['sy'] ?? null,
            'status' => $data['status'] ?? 'A',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->create($request->all());

        return redirect('/home')->with('success', 'Student Registered Successfully');
    }
}
