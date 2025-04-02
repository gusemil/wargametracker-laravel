<x-layout>
    <div id="" class="w-50 container bg-dark p-3">
        <div class="container text-white">
            <div class="row">
                <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
                    <div class="bg-black mt-1 mb-1 p-3">
                        <div class="">
                            <h1 class="mt-3 mb-3">User Dashboard</h1>
                        </div>
                        <div class="">
                            <h4><span class="text-info">Username:</span> {{ $user->name }}</h4>
                            <h3><span class="text-info">Leaderboards ranking:</span> <span
                                    class="text-success">#{{ $user_rank }}</span></h3>
                            <h4><span class="text-info">Email:</span> {{ $user->email }} </h4>
                            <h4><span class="text-info">Your total ELO score:</span> {{ $user->totalELO }}</h4>
                            <h4><span class="text-info">Total Matches Played:</span> {{ $user->total_matches_played }}
                            </h4>
                            <h4><span class="text-info">Wins:</span> {{ $user->wins }}</h4>
                            <h4><span class="text-info">Losses:</span> {{ $user->losses }}</h4>
                            <h4><span class="text-info">Draws:</span> {{ $user->draws }}</h4>
                            <h4><span class="text-info">Win/Lose Ratio:</span>
                                <?php if ($user->wins != 0 and $user->losses != 0) {
                                    echo number_format((float) ($user->wins / $user->losses), 1, '.', '');
                                } else {
                                    echo '0';
                                } ?>
                            </h4>
                            <?php if ($user->is_admin == 1) {
                                echo "
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <h3 class='text-success'>You are an admin</h4>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ";
                            }
                            ?>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <h3>My Matches</h3>
                            <ul class="text-white list-unstyled">
                                @forelse ($matches_with_user as $match)
                                    <li>
                                        <h5>
                                            <span class=""> {{ $match->name }} </span>
                                            <span class='text-primary'>(ID: {{ $match->id }})</span>
                                            <span class="text-warning">{{ $match->user_1_score }} -</span>
                                            <span class="text-warning">{{ $match->user_2_score }}</span>
                                            <span><a href={{ route('matches.show', ['id' => $match->id]) }}>Match
                                                    Details</a></span>
                                        </h5>
                                    </li>
                                @empty
                                    <h3>
                                        <span class="text-danger"> No matches played yet </span>
                                    </h3>
                                @endforelse
                            </ul>
                        </div>
                        {{ $matches_with_user->withPath(url()->current())->links('vendor/pagination/bootstrap-5') }}
                    </div>
                </div>
</x-layout>
