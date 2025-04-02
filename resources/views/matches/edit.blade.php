<x-layout>
    <div class="container bg-dark p-3">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-8 w-100 mx-auto p-1 m-3">
                    <div class="card-header">
                        <h2 class="text-info">Update Match</h2>
                    </div>
                    <div>
                        <?php /*if (isset($_SESSION['addmatcherror'])) {
                                echo "<p class='text-danger'><b>" . $_SESSION['addmatcherror'] . '</b></p>';
                            } */
                        ?>
                    </div>
                    <form method="post" action="{{ route('matches.update', $match) }}">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label for="" class="form-label">Player 1</label>
                            <select name="user_1" class="form-control">
                                @foreach ($users as $user1)
                                    <option value="{{ $user1->id }}">{{ $user1->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Player 2</label>
                            <select name="user_2" class="form-control">
                                @foreach ($users as $user2)
                                    <option value="{{ $user2->id }}">{{ $user2->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Player 1 Score</label>
                            <input type=number name="user_1_score" class="form-control" value="0"></input>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Player 2 Score</label>
                            <input type=number name="user_2_score" class="form-control" value="0"></input>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Game</label>
                            <select name="game" class="form-control">
                                @foreach ($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Group</label>
                            <select name="playgroup" class="form-control">
                                @foreach ($playgroups as $playgroup)
                                    <option value="{{ $playgroup->id }}">{{ $playgroup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Match Name</label>
                            <input type=text name="match_name" class="form-control"
                                value="{{ old('match_name', $match->name) }}" minlength="4" maxlength="20"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"></input>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <input type=text name="description" class="form-control"
                                value="{{ old('description', $match->description) }}" minlength="4" maxlength="100"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"></input>
                        </div>
                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-primary">Submit
                                Match</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout>
