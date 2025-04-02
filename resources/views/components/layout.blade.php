<!--HEADER-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php if (isset($page_title)) {
            echo "$page_title";
        } ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0daebcb4f2.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script defer src="{{ asset('js/styling.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type='text/css' href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />
    <link rel="stylesheet" href="{{ asset('css/styling.css') }}">
</head>

<body class="bg-black">
    <x-nav></x-nav>
    <!--HEADER END-->
    <!-- FLASH MESSAGES -->
    @if (session('status'))
        <div class="alert alert-success" id="success-flash">

            {{ session('status') }}

        </div>
        <script>
            //TIMEOUT FLASH MESSAGE
            setTimeout(function() {
                $('#success-flash').fadeOut('slow');
            }, 3000); // 3 sec
        </script>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" id="error-flash">

            {{ session('error') }}

        </div>

        <script>
            //TIMEOUT FLASH MESSAGE
            setTimeout(function() {
                $('#error-flash').fadeOut('fast');
            }, 5000); // 5 sec
        </script>
    @endif
    <!-- FLASHMESSAGES END -->

    <!-- CONTENT -->
    {{ $slot }}
    <!-- CONTENT -->

    <!--FOOTER START-->
    <footer class="my-footer bg-black text-center fixed-bottom">
        <div class="container text-center">
            <a class="btn btn-lg btn-outline-light btn-floating m-2 my-tooltip" data-bs-toggle="tooltip"
                data-bs-title="Contact me via LinkedIn!" href="https://fi.linkedin.com/in/emil-gusg%C3%A5rd-9863571a4"
                target="_blank" rel="noopener noreferrer" role="button">
                <i class="fa fa-linkedin"></i>
            </a>
            <a class="btn btn-lg btn-outline-light btn-floating m-2 my-tooltip" data-bs-toggle="tooltip"
                data-bs-title="Send Me Mail" href="mailto:goosedev@hotmail.com" target="_blank"
                rel="noopener noreferrer" role="button">
                <i class="fa-regular fa-envelope"></i>
            </a>
            <a class="btn btn-lg btn-outline-light btn-floating m-2 my-tooltip" data-bs-toggle="tooltip"
                data-bs-title="My projects on GitHub" href="https://github.com/gusemil" target="_blank"
                rel="noopener noreferrer" role="button">
                <i class="fa fa-github"></i>
            </a>
            <a class="btn btn-lg btn-outline-light btn-floating m-2 my-tooltip" data-bs-toggle="tooltip"
                data-bs-title="Check my projects on Youtube!"
                href="https://www.youtube.com/playlist?list=PLlujc4lWOv3Z0bt-I3f-pHoFYhx-2lO45" target="_blank"
                rel="noopener noreferrer" role="button">
                <i class="fa fa-youtube"></i>
            </a>
        </div>
    </footer>
    <!-- Footer End -->
</body>

</html>
