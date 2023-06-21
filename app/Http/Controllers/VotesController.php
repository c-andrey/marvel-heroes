<?php

namespace App\Http\Controllers;

use App\Http\Requests\Votes\StoreVotesRequest;
use App\Models\Votes;
use Exception;
use Illuminate\Http\Request;
use PDOException;

class VotesController extends Controller
{
    function store(StoreVotesRequest $request)
    {
        try {
            $params = $request->all();

            switch ($params['action']) {
                case 'up':
                    $votes = Votes::where('hero_id', $params['hero_id'])->first();

                    if ($votes) {
                        $votes->increment('votes');
                    } else {
                        Votes::create($params);
                    }
                    break;

                case 'down':
                    $votes = Votes::where('hero_id', $params['hero_id'])->first();

                    if ($votes) {
                        $votes->decrement('votes');
                    }

                    break;
                default:
                    throw new Exception('Invalid action', 400);
                    break;
            }

            return response()->json(['voted' => true], 200);
        } catch (PDOException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() || 500);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() || 500);
        }
    }
}
