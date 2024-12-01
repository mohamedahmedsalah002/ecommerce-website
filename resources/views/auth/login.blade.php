@include('layouts.head.head');

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <style>
        /* Reseting */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            max-width: 350px;
            min-height: 500px;
            padding: 40px 30px 30px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            text-align: center;
            color: #555;
            margin-top: 20px;
        }

        .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
        }

        .form-field input {
            width: 100%;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px;
        }

        .form-field .fas {
            color: #555;
        }

        .btn {
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border-radius: 25px;
            border: none;
            box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
            letter-spacing: 1.3px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #039BE5;
        }

        .text-center a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .text-center a:hover {
            color: #039BE5;
        }

        .alert {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="wrapper">
       
        <div class="name">
            Login 
        </div>
        <form class="form-horizontal p-3 mt-3" action="{{ route('handleLogin') }}" method="post" autocomplete="off">
            @csrf
            <div class="row pb-4">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-field d-flex align-items-center">
                <input name="password" placeholder="Password"  type="password"  required>
            </div>

            <button class="btn mt-3">Login</button>
        </form>
        <div class="text-center mt-3">
           New User ? <a href="{{route('register')}}">Sign up</a>
        </div>
    </div>

</body>
</html>
