<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayedMatch;
use App\Models\User;
use App\Models\Game;
use App\Models\Playgroup;

class PlayedMatchesController extends Controller
{
    public function index()
    {
        return view('matches.index', [
            'matches' => PlayedMatch::orderByDesc('created_at')->paginate(8) //How many entries are shown per page
        ]);
    }

    public function create()
    {
        if (Auth::user()->is_admin == false) {
            return back()->with('error', "You don't have permission to create a match");
        }

        $matches = PlayedMatch::all();
        $users = User::orderBy("name", "asc")->get();
        $games = Game::all();
        $playgroups = Playgroup::all();
        return view('matches.create', compact('matches', 'users', 'games', 'playgroups'));
    }

    public function show($id)
    {
        $match = PlayedMatch::find($id);
        if ($match == null) {
            return redirect()->route('matches.index')
                ->with('status', 'Match you tried to access does not exist!');
        }
        return view('matches.show', compact('match'));
    }

    public function edit(PlayedMatch $match)
    {
        $users = User::all()->sortBy('name');
        $games = Game::all();
        $playgroups = Playgroup::all();
        return view('matches.edit', compact('match', 'users', 'games', 'playgroups'));
    }

    public function store(Request $request)
    {
        if ($request->user_1 == $request->user_2) {
            //Cant have a match with yourself!
            return back()->with('error', "You can't have a match with yourself");
        }

        $match = new PlayedMatch();

        $user_1_name = DB::table('users')->where('id', $request->user_1)->value('name');
        $user_2_name = DB::table('users')->where('id', $request->user_2)->value('name');

        if ($request->match_name == null || $request->match_name == "") {
            $match->name = "$user_1_name VS $user_2_name";
        } else {
            $match->name = $request->match_name;
        }

        $match->description = $request->description;


        //From form
        $match->user_1_id = $request->user_1;
        $match->user_2_id = $request->user_2;
        $match->user_1_name = $user_1_name;
        $match->user_2_name = $user_2_name;
        $match->user_1_score = $request->user_1_score;
        $match->user_2_score = $request->user_2_score;
        $match->game = DB::table('games')->where('id', $request->game)->value('name');
        $match->playgroup = DB::table('playgroups')->where('id', $request->playgroup)->value('name');

        if ($match->user_1_score > $match->user_2_score) {
            $match->winner = 1;
        } else if ($match->user_1_score < $match->user_2_score) {
            $match->winner = -1;
        } else {
            $match->winner = 0;
        }

        //Calculate ELO and update users

        $match_results = null;

        if ($match->winner != 0) {
            $match_results = $this->CalculateELOAndUpdateUsers($match->user_1_id, $match->user_2_id, $match->winner);
            $match->user_1_elo = $match_results[0];
            $match->user_2_elo = $match_results[1];
            $match->user_1_elo_change = $match_results[2];
            $match->user_2_elo_change = $match_results[3];
        } else {
            //Draw
            $match_results = $this->CalculateELOAndUpdateUsers($match->user_1_id, $match->user_2_id, $match->winner);
            $match->user_1_elo = DB::table('users')->where('id', $request->user_1)->value('totalELO');
            $match->user_2_elo = DB::table('users')->where('id', $request->user_2)->value('totalELO');
            $match->user_1_elo_change = 0;
            $match->user_2_elo_change = -0;
        }

        $match->save();

        return redirect()->route('matches.index')->with('status', "New match added: $match->name");
    }

    public function destroy(PlayedMatch $match)
    {
        //0. Get both users from the match
        $user_1 = User::find($match->user_1_id);
        $user_2 = User::find($match->user_2_id);

        //1. Check if the match is latest for both users
        $matches = PlayedMatch::all();
        //Find all matches users 1 and 2
        $matches_with_user_id_1_for_user_1 = $matches->where("user_1_id", $user_1->id);
        $matches_with_user_id_2_for_user_1 = $matches->where("user_2_id", $user_1->id);
        $matches_with_user_1 = collect($matches_with_user_id_1_for_user_1)->merge($matches_with_user_id_2_for_user_1)->sortByDesc("created_at");

        $matches_with_user_id_1_for_user_2 = $matches->where("user_1_id", $user_2->id);
        $matches_with_user_id_2_for_user_2 = $matches->where("user_2_id", $user_2->id);
        $matches_with_user_2 = collect($matches_with_user_id_1_for_user_2)->merge($matches_with_user_id_2_for_user_2)->sortByDesc("created_at");

        echo $matches_with_user_1->first()->id . " " . $matches_with_user_2->first()->id;
        if ($match->id == $matches_with_user_1->first()->id && $match->id == $matches_with_user_2->first()->id) {

            //Check if match was draw or win/lose
            if ($match->user_1_score == 0 && $match->user_2_score == 0) {
                //Draw. Do not change ELO, but reduce draws
                $user_1->draws = $user_1->draws - 1;
                $user_2->draws = $user_2->draws - 1;
            } else {
                //Revert ELO changes and wins/losses to users
                if ($match->user_1_elo_change > 0) {
                    $user_1->totalELO = $user_1->totalELO - $match->user_1_elo_change;
                    $user_1->wins = $user_1->wins - 1;
                } else if ($match->user_1_elo_change < 0) {
                    $user_1->totalELO = $user_1->totalELO + -1 * $match->user_1_elo_change;
                    $user_1->losses = $user_1->losses - 1;
                }

                if ($match->user_2_elo_change > 0) {
                    $user_2->totalELO = $user_2->totalELO + $match->user_2_elo_change;
                    $user_2->wins = $user_2->wins - 1;
                } else if ($match->user_2_elo_change < 0) {
                    $user_2->totalELO = $user_2->totalELO + -1 * $match->user_2_elo_change;
                    $user_2->losses = $user_2->losses - 1;
                }
            }

            $user_1->total_matches_played -= 1;
            $user_2->total_matches_played -= 1;

            $user_1->save();
            $user_2->save();

            $match->delete();

            return redirect()->route('matches.index')
                ->with('status', 'Match Deleted');
        } else {
            return back()->with('error', 'Not allowed to delete: One of the users in the match has had later match');
        }
    }

    public function CalculateELOAndUpdateUsers(string $user_1_id, string $user_2_id, int $winner): array
    {
        $player_1_wins = false;

        $player_1_old_score = DB::table('users')->where('id', $user_1_id)->value('totalELO');
        $player_2_old_score = DB::table('users')->where('id', $user_2_id)->value('totalELO');

        //User1 and user2 from DB
        $user_1_update = User::find($user_1_id);
        $user_2_update = User::find($user_2_id);

        $user_1_update->total_matches_played = DB::table('users')->where('id', $user_1_id)->value('total_matches_played') + 1;
        $user_2_update->total_matches_played = DB::table('users')->where('id', $user_2_id)->value('total_matches_played') + 1;

        if ($winner == 1) {
            $player_1_wins = true;
        } else if ($winner == -1) {
            $player_1_wins = false;
        } else {
            //Draw
            $player_1_matches_amount =  DB::table('users')->where('id', $user_1_id)->value('total_matches_played');
            $player_2_matches_amount = DB::table('users')->where('id', $user_2_id)->value('total_matches_played');
            //Update players
            $user_1_update->draws = DB::table('users')->where('id', $user_1_id)->value('draws') + 1;
            $user_2_update->draws = DB::table('users')->where('id', $user_2_id)->value('draws') + 1;

            $user_1_update->save();
            $user_2_update->save();

            return array($player_1_old_score, $player_2_old_score, 0, 0); //No ELO change
        }

        $player_1_matches_amount =  DB::table('users')->where('id', $user_1_id)->value('total_matches_played');
        $player_2_matches_amount = DB::table('users')->where('id', $user_2_id)->value('total_matches_played');

        $player_1_score = $player_1_old_score;
        $player_2_score = $player_2_old_score;

        $amountOfGamesPlayed = 1;

        //Propability
        $p1 = (1.0 / (1.0 + Pow(10, (($player_2_score - $player_1_score) / 400)))) / $amountOfGamesPlayed; //400 * wins - losses = 400 * 1
        $p2 = (1.0 / (1.0 + Pow(10, (($player_1_score - $player_2_score) / 400)))) / $amountOfGamesPlayed; //400 * wins - losses = 400 * 1

        //Update ranking

        //Algorithm help: https://www.omnicalculator.com/sports/elo
        //https://www.noveltech.dev/elo-ranking-csharp-unity

        //FIDE uses k-factor of 40 for players under 2300 ELO and less than 30 games: https://en.wikipedia.org/wiki/Elo_rating_system#Most_accurate_K-factor
        //20 for over 30 games but under 2400 ELO
        //10 if 2400 or over ELO and at least 30 games

        $k = 0;

        //If player 1 wins
        if ($player_1_wins) {
            if ($player_1_old_score < 2300) {
                if ($player_1_matches_amount <= 30) {
                    $k = 40;
                } else {
                    $k = 20;
                }
            } else {
                $k = 10;
            }

            $winner = 1;
            $player_1_score = round($player_1_score + ($k * (1 - $p1)) * $amountOfGamesPlayed); //1 win - 0 losses = 1
            $player_2_score = round($player_2_score +  ($k * ($p1 - 1)) * $amountOfGamesPlayed); //0 wins - 1 losses = -1

            //Update players
            $user_1_update->wins = DB::table('users')->where('id', $user_1_id)->value('wins') + 1;
            $user_2_update->losses = DB::table('users')->where('id', $user_2_id)->value('losses') + 1;
        } else //Else player 2 wins
        {
            if ($player_2_old_score < 2300) {
                if ($player_2_matches_amount <= 30) {
                    $k = 40;
                } else {
                    $k = 20;
                }
            } else {
                $k = 10;
            }

            $winner = -1;
            $player_2_score = round($player_2_score + ($k * (1 - $p2)) * $amountOfGamesPlayed); //1 win - 0 losses = 1
            $player_1_score = round($player_1_score +  ($k * ($p2 - 1)) * $amountOfGamesPlayed); //0 wins - 1 losses = -1    

            //Update players
            $user_2_update->wins = DB::table('users')->where('id', $user_2_id)->value('wins') + 1;
            $user_1_update->losses = DB::table('users')->where('id', $user_1_id)->value('losses') + 1;
        }

        //Update players
        $user_1_update->totalELO = $player_1_score;
        $user_1_update->save();

        $user_2_update->totalELO = $player_2_score;
        $user_2_update->save();

        $player_1_elo_change = $player_1_score - $player_1_old_score;
        $player_2_elo_change = $player_2_score - $player_2_old_score;

        return array($player_1_score, $player_2_score, $player_1_elo_change, $player_2_elo_change);
    }
}
