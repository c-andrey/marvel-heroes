<?php

namespace App\Http\Controllers;

use App\Http\Requests\Votes\StoreVotesRequest;
use App\Models\Votes;
use Exception;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    function store(StoreVotesRequest $request)
    {
        try {
            $params = $request->all();

            $vote = Votes::create($params);

            return response()->json(['created' => true], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode() || 500);
        }
    }
}
