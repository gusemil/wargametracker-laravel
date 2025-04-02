@php

    $winner = $match->winner;
    $winner_id;
    $is_draw = false;

    if ($winner == 1) {
        //Player 1 wins
        $winner_id = $match->user_1_id;
        $winner_name = $match->user_1_name;
    } elseif ($winner == -1) {
        //Player 2 wins
        $winner_id = $match->user_2_id;
        $winner_name = $match->user_2_name;
    } else {
        //Draw
        $is_draw = true;
    }
@endphp

<x-layout>
    <div id="" class="container bg-dark p-3">
        <div class="container text-white">
            <div class="row">
                <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
                    <div class="bg-black mt-1 mb-1 p-3">
                        <div class="">
                            <h1>Match Result (Match ID: <span class="text-info"> {{ $match->id }}</span> - <span
                                    class="text-info"> {{ $match->created_at }}</span>)</h1>
                            <div class="">
                                <h2>Player 1: <a class="text-warning"
                                        href={{ route('players.show', ['id' => $match->user_1_id]) }}>
                                        {{ $match->user_1_name }} </a> VS Player 2: <a class="text-warning"
                                        href={{ route('players.show', ['id' => $match->user_2_id]) }}>
                                        {{ $match->user_2_name }} </a></h2>
                                <h2><span class="text-primary">
                                        @if (!$is_draw)
                                            <p>Winner: <a class='text-danger'
                                                    href={{ route('players.show', ['id' => $winner_id]) }}>{{ $winner_name }}</a><br>With
                                                a score of
                                                {{ $match->user_1_score }}
                                                against a score of
                                                {{ $match->user_2_score }} </p>
                                        @else
                                            <p>
                                                The match is a draw!<br> With scores: <span class='text-warning'>
                                                    {{ $match->user_1_score }} - {{ $match->user_2_score }} </span>
                                            </p>
                                        @endif
                                    </span></h2>
                                <h4><a class="text-warning"
                                        href={{ route('players.show', ['id' => $match->user_1_id]) }}>
                                        {{ $match->user_1_name }}</a> : Current ELO <span class="text-info">
                                        {{ $match->user_1_elo }} </span>, with an ELO
                                    score change of <span class="text-info"> {{ $match->user_1_elo_change }} </span>
                                </h4>
                                <h4><a class="text-warning"
                                        href={{ route('players.show', ['id' => $match->user_2_id]) }}>
                                        {{ $match->user_2_name }} </a> : Current ELO <span class="text-info">
                                        {{ $match->user_2_elo }} </span>, with an ELO
                                    score change of <span class="text-info"> {{ $match->user_2_elo_change }} </span>
                                </h4>
                                <h4>Game: <span class="text-info">{{ $match->game }} </span> at
                                    <span class="text-info"> {{ $match->playgroup }} </span>
                                </h4><br>
                                <h5>Description: <span class="text-success"> {{ $match->description }} </span></h5>
                            </div>
                            @can('delete', $match)
                                <form method="post" action="{{ route('matches.destroy', $match) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class='btn btn-danger mt-3'>Delete
                                        Match</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
