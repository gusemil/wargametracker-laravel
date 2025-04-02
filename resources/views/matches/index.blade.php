<x-layout>
    <div class="container bg-dark p-3 mb-5">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-8 w-100 mx-auto p-1 m-3">
                    <div class="">
                        <div class="">
                            <h1 class="text-center mb-3">Matches From Latest to Oldest</h1>
                        </div>
                        <div class='row justify-content-center'>
                            @forelse ($matches as $match)
                                <div class='col col-6 col-md-4 card my-card-styling bg-black' style='width: 18rem;'>
                                    <div class='card-body'>
                                        <h2 class='card-title text-center text-white mb-3'>
                                            <span class="fs-1"> {{ $match->name }} </span>
                                            <span class='text-primary'>(ID: {{ $match->id }})</span>
                                        </h2>
                                        <p class='card-text text-center text-info mt-4 mb-3 fs-5'> <span
                                                class='text-warning fs-3'><a class='text-danger'
                                                    href={{ route('players.show', ['id' => $match->user_1_id]) }}>{{ $match->user_1_name }}</a>
                                                {{ $match->user_1_score }}<span class='text-white'> -
                                                </span>{{ $match->user_2_score }} <a class='text-danger'
                                                    href={{ route('players.show', ['id' => $match->user_2_id]) }}>{{ $match->user_2_name }}</a></span>
                                            <br>
                                            <span class='fs-3'>{{ $match->game }}<span
                                                    class='text-white'>@</span><span
                                                    class='text-warning'>{{ $match->playgroup }}</span></span> <br>
                                            {{ $match->created_at }}
                                        </p>
                                        <div class='form-group text-center'>
                                            <a href={{ route('matches.show', ['id' => $match->id]) }}><button
                                                    class='btn btn-primary'>Check Match Info</button></a>
                                            @can('delete', $match)
                                                <form method="post" action="{{ route('matches.destroy', $match) }}">
                                                    @csrf
                                                    @method('delete')

                                                    <button class='btn btn-danger mt-3'>Delete
                                                        Match</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center">
                                    <h2>No Matches found</h2>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
                {{ $matches->links('vendor/pagination/bootstrap-5') }}
            </div>
        </div>

    </div>
</x-layout>
