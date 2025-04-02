<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\PlayedMatch;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class PlayerController extends Controller
{
    public function index()
    {
        return view('players.index', [
            'players' => User::orderByDesc('totalELO')->paginate(9) //How many entries are shown per page
        ]);
    }

    public function create(): View
    {
        $users = User::all();
        return view('players.create', compact('users'));
    }

    public function store(Request $request): void
    {
        $player = new User();

        $player->name = $request->name;
        $player->password = $request->password;
        $player->email = $request->email;
        $player->totalELO = $request->totalELO;
        $player->total_matches_played = $request->total_matches_played;
        $player->wins = $request->wins;
        $player->losses = $request->losses;
        $player->draws = $request->draws;
        $player->verify_token = $request->verify_token;
        $player->is_verified = $request->is_verified;
        $player->is_admin = $request->is_admin;
    }

    public function show($id)
    {
        //We are passing an id, not a user object
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('players.index')
                ->with('status', 'User you tried to access does not exist!');
        }

        $user_rank = $this->returnUserRank($user);

        $matches = PlayedMatch::all();
        //Find all matches with current user as either player 1 or player 2 and combine the collections
        $matches_with_user_id_1 = $matches->where("user_1_id", $user->id);
        $matches_with_user_id_2 = $matches->where("user_2_id", $user->id);
        $matches_with_user = collect($matches_with_user_id_1)->merge($matches_with_user_id_2)->sortByDesc("created_at");

        $matches_with_user = $this->paginateAnArray($matches_with_user);

        return view('players.show', compact('user', 'user_rank', 'matches_with_user'));
    }

    //https://www.itsolutionstuff.com/post/how-to-create-pagination-from-array-in-laravelexample.html
    public function paginateAnArray($items, $perPage = 5, $page = null, $options = [])

    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function returnUserRank(User $user)
    {
        $sortedUsers = User::orderByDesc('totalELO')->get();
        $user_rank = 0;
        for ($i = 0; $i <= count($sortedUsers) - 1; $i++) {
            if ($sortedUsers[$i]->id == $user->id) {
                $user_rank = $i + 1;
            }
        }

        return $user_rank;
    }
}
