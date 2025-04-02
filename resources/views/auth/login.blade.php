<x-layout>
    <div class="container bg-dark p-3">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-8 w-100 mx-auto p-1 m-3">
                    <div class="card-header">
                        <h2 class="text-info">Login Form</h2>
                    </div>
                    <div>
                        <?php /*if (isset($_SESSION['loginerror'])) {
                            echo "<p class='text-danger'><b>" . $_SESSION['loginerror'] . '</b></p>';
                        }*/
                        ?>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login.authenticate') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" aria-describedby="emailHelp"
                                    minlength="6" maxlength="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" minlength="8"
                                    maxlength="32">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('register') }}" class="text-info my-nav-link">Need to create an account?
                                Click here to register</a>
                        </div>
                        <!-- TODO: LATER
                        <div class="mt-3">
                            <a href="forgotpassword.php" class="text-info my-nav-link">Forgot your password? Click
                                here to reset</a>
                        </div>
                        -->
                        <!--TODO: LATER-->
                        <!--
                        <div class="mt-1">
                            <a href="verification.php" class="text-info my-nav-link">Click here to verify your email</a>
                        </div>
                            -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
