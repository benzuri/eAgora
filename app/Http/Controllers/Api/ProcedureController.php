<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Http\Resources\ProcedureResource;
use Illuminate\Support\Facades\Validator;

class ProcedureController extends BaseController
{
    /**
     * Display a listing of the resource, filtered by type and state
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type_id' => 'nullable|numeric|exists:types,id',
            'state_id' => 'nullable|numeric|exists:states,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $procedures = Procedure::where($input)->get();

        return $this->sendResponse(ProcedureResource::collection($procedures), 'Procedures retrieved successfully.');
    }

    /**
     * Store a newly created resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|string|unique:procedures,title',
            'type_id' => 'required|exists:types,id',
            'state_id' => 'required|exists:states,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Procedure = Procedure::create($input);

        return $this->sendResponse(new ProcedureResource($Procedure), 'Procedure created successfully.');
    }

    /**
     * Display the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Procedure = Procedure::find($id);

        if (is_null($Procedure)) {
            return $this->sendError('Procedure not found.');
        }

        return $this->sendResponse(new ProcedureResource($Procedure), 'Procedure retrieved successfully.');
    }

    /**
     * Update the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Procedure $Procedure)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|string|unique:procedures,title',
            'type_id' => 'required|exists:types,id',
            'state_id' => 'required|exists:states,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Procedure->title = $input['title'];
        $Procedure->type_id = $input['type_id'];
        $Procedure->state_id = $input['state_id'];
        $Procedure->save();

        return $this->sendResponse(new ProcedureResource($Procedure), 'Procedure updated successfully.');
    }

    /**
     * Remove the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Procedure::destroy($id);
        return $destroy ?
            $this->sendResponse([], 'Procedure deleted successfully.') :
            $this->sendError('Procedure not found.');
    }
}
