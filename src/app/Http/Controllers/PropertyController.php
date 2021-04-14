<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\PropertyInterface;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    private PropertyInterface $service;

    public function __construct(PropertyInterface $propertyService)
    {
        $this->service = $propertyService;
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
            $data = ['message' => 'Property saved successfully'];
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
            $data = ['message' => 'Property updated successfully'];
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
     * Update the purchase info from the propertie passed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setPurchased($id, $value)
    {
        if(!in_array($value, [0, 1])) {
            return $this->jsonResponse(['message' => 'Invalid value'], 400);    
        }

        try {
            $this->service->save(['purchased' => $value], $id);
            $data = ['message' => 'Purchased info updated successfully'];
        } catch(\Exception $e) {    
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
            'address' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'total_area' => 'required',
            'value' => 'required',
            'discount' => 'required',
            'owner_id' => 'required|exists:App\Models\User,id'
        ]);

        if($validator->fails()) {
            $data = ['data' => $validator->errors()];

            return $this->jsonResponse($data, 400);
        }

        $countNotPurchased = $this->service->countPropertiesNotPurchased($request->input('owner_id'));
        if($countNotPurchased) {
            if($request->method() === "POST" || ($request->method() === "PUT" && $request->input('purchased') === 0)) {
                $error = new \stdClass();
                $error->purchased = ['The owner has the maximum of not purchased properties already'];
                $data = ['data' => $error];
                
                return $this->jsonResponse($data, 400);
            }
        }

        return false;
    }
}
