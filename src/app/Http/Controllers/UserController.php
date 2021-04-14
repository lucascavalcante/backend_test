<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\UserInterface;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private UserInterface $service;

    public function __construct(UserInterface $userService)
    {
        $this->service = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['data'] = $this->service->getAll();
        } catch(\Exception $e) {
            return $this->errorResponse($e->getCode());
        }

        return $this->jsonResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->dataValidation($request);
        if($validation) {
            return $validation;
        }

        try {
            $this->service->save($request->all());
            $data = ['message' => 'User saved successfully'];
        } catch(\Exception $e) {    
            return $this->errorResponse($e->getCode());
        }

        return $this->jsonResponse($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data['data'] = $this->service->getOne($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getCode());
        }
        
        return $this->jsonResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $this->dataValidation($request);
        if($validation) {
            return $validation;
        }

        try {
            $this->service->save($request->all(), $id);
            $data = ['message' => 'User updated successfully'];
        } catch(\Exception $e) {    
            return $this->errorResponse($e->getCode());   
        }

        return $this->jsonResponse($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->service->delete($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getCode());   
        }

        return $this->jsonResponse([], 204);
    }

    /**
     * Display a listing of properties from a specific user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProperties($id)
    {
        try {
            $data['data'] = $this->service->getProperties($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getCode());
        }
        
        return $this->jsonResponse($data);
    }

    /**
     * Validation for data passed
     * 
     * @param Request $request
     * @return bool
     */
    public function dataValidation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            $data = ['data' => $validator->errors()];

            return $this->jsonResponse($data, 400);
        }

        return false;
    }
}
