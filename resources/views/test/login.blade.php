<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="BackOffice/assets/auth/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
    <link href="BackOffice/assets/auth/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
    <link href="BackOffice/assets/auth/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">

    <title>Login Page</title>
</head>
<body>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50">Sign in to continue to PharaIk.</p>
                                <a href="" class="logo logo-admin">
                                    <img src="BackOffice/assets/auth/images/logo-sm.png" height="24" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form class="mt-4" action="index.html">

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customControlInline">
                                                <label class="form-check-label" for="customControlInline">Remember me</label>
                                            </div>
                                        </div><br>
                                        <div class="col-sm-6 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
 

    <script src="BackOffice/assets/auth/libs/node-waves/waves.min.js"></script>
    <script src="BackOffice/assets/auth/libs/simplebar/simplebar.min.js"></script>
    <script src="BackOffice/assets/auth/libs/metismenu/metisMenu.min.js"></script>
    <script src="BackOffice/assets/auth/libs/jquery/jquery.min.js"></script>
    <script src="BackOffice/assets/auth/js/app.js"></script>

</body>
</html>
