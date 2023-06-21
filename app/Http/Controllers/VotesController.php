<?php

namespace App\Http\Controllers;

use App\Http\Requests\Votes\ListHeroesWithVotesRequest;
use App\Http\Requests\Votes\StoreVotesRequest;
use App\Models\Votes;
use App\Services\HeroesRemoteService\HeroesRemoteService;
use Exception;
use Illuminate\Http\Request;
use PDOException;

class VotesController extends Controller
{

    /**
     * @var HeroesRemoteService
     */
    private $_heroesRemoteService;

    function __construct()
    {
        $this->_heroesRemoteService = new HeroesRemoteService();
    }

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
                        Votes::create(['votes' => 1, ...$params]);
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

            return response()->json(['voted' => true, 'data' => Votes::where('hero_id', $params['hero_id'])->first()], 200);
        } catch (PDOException $e) {
            return response()->json(['voted' => false, 'error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['voted' => false, 'error' => $e->getMessage()], $e->getCode());
        }
    }

    function listHeroesWithVotes(ListHeroesWithVotesRequest $request)
    {
        try {
            $params = $request->all();

            $heroes = $this->_heroesRemoteService->getHeroes($params);

            $heroes['page'] = (int) $params['page'];
            $heroes['pages'] = (int) ceil($heroes['total'] / $heroes['limit']);

            $heroes['results'] = collect($heroes['results'])->map(function ($hero) {
                $votes = Votes::where('hero_id', $hero['id'])->first();

                if ($votes) {
                    $hero['votes'] = $votes['votes'];
                }

                return $hero;
            })->sortByDesc('votes')->values();


            return response()->json(['heroes' => $heroes], 200);
        } catch (PDOException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
