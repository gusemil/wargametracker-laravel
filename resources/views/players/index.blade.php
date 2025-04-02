<x-layout>
    <div class="text-white mb-5">
        <div class="container bg-dark p-3">
            <div class="container text-white">
                <div class="row">
                    <div class="col-md-8 w-100 mx-auto p-1 m-3">
                        <div class="">
                            <div class="">
                                <h1 class="text-center mb-3">Players By Ranking</h1>
                            </div>
                            <div class='row justify-content-center'>
                                <?php $loop_index = 1; ?>
                                @forelse ($players as $player)
                                    <?php $win_lose = 0;
                                    if ($player->wins != 0 and $player->losses != 0) {
                                        $win_lose = number_format((float) ($player->wins / $player->losses), 1, '.', '');
                                    }
                                    ?>
                                    <div class='col col-6 col-md-4 card my-card-styling bg-black' style='width: 20rem;'>
                                        <div class='card-body'>
                                            <h2 class='card-title text-center text-white mb-3'>
                                                <span class="fs-1 text-success">#{{ $loop_index }}</span>
                                                <a class="fs-1 text-white"
                                                    href={{ route('players.show', ['id' => $player->id]) }}>
                                                    {{ $player->name }}</a> <span class='text-primary'>(ID:
                                                    {{ $player->id }})</span>
                                            </h2>
                                            <p class='card-text text-center text-info mt-4 mb-3 fs-5'>
                                                <span class='fs-3'>ELO:<span
                                                        class='text-white'>{{ $player->totalELO }}</span></span> <br>
                                                WINS:<span class='text-white'>{{ $player->wins }}</span> LOSSES:<span
                                                    class='text-white'>{{ $player->losses }}</span> DRAWS:<span
                                                    class='text-white'>{{ $player->wins }}</span> MATCHES:<span
                                                    class='text-white'>{{ $player->matches }}</span> <br> WIN/LOSER
                                                RATIO:<span class='text-white'>{{ $win_lose }}</span>
                                            </p>
                                            <div class='form-group text-center'>
                                                <a href={{ route('players.show', ['id' => $player->id]) }}><button
                                                        class='btn btn-primary'>Check User Page</button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $loop_index++; ?>
                                @empty
                                    <div class="text-center">
                                        <h2>No players found</h2>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                {{ $players->links('vendor/pagination/bootstrap-5') }}
            </div>
        </div>
    </div>
</x-layout>
