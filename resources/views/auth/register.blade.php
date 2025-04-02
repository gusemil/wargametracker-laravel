<x-layout>
    <div class="container bg-dark p-3">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-8 w-100 mx-auto p-1 m-3">
                    <div class="card-header">
                        <h2 class="text-info">Registration Form</h2>
                    </div>
                    <div>
                        <?php /*if (isset($_SESSION['registererror'])) {
                            echo "<p class='text-danger'><b>" . $_SESSION['registererror'] . '</b></p>';
                        } */
                        ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">UserName</label>
                                <input type="text" id="name" name="name" class="form-control" minlength="4"
                                    maxlength="12" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    aria-describedby="emailHelp" minlength="6" maxlength="40"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    minlength="8" maxlength="32">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password Verify</label>
                                <input type="password" id="password_verify" name="password_verify" class="form-control"
                                    minlength="8" maxlength="32">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Register
                                    Now</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('login') }}" class="text-info my-nav-link">Already have an account?
                                Click here to login</a>
                        </div>
                        <div class="mt-3">
                            <!-- TODO: Do email verificationor not-->
                            <!--
                            <a href="verification.php" class="text-info my-nav-link">Already have an account? Click
                                here to verify your email</a>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
