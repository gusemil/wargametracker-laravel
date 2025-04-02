<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PlayedMatch;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve the currently authenticated user...
        $user = Auth::user();

        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();

        $user = User::find($id);
        $matches = PlayedMatch::all();
        //Find all matches with admin as either player 1 or player 2 and combine the collections
        $matches_with_user_id_1 = $matches->where("user_1_id", $user->id);
        $matches_with_user_id_2 = $matches->where("user_2_id", $user->id);
        $matches_with_user = collect($matches_with_user_id_1)->merge($matches_with_user_id_2)->sortByDesc("created_at");;

        $matches_with_user = $this->paginateAnArray($matches_with_user);

        $user_rank = $this->returnUserRank($user);

        return view('dashboard.index', compact('user', 'user_rank', 'matches_with_user'));
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
        //Sort by ELO from highest to lowest.
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
