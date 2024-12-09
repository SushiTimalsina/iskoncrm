<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ISKCON</title>
		<link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body { background-color: #fff; color: #636b6f; font-family: 'Nunito', sans-serif; font-weight: 200; height: 100vh; margin: 0; }
            .full-height { height: 100vh; }
			.flex-center { align-items: center; display: flex; justify-content: center; }
			.position-ref { position: relative; }
            .content { text-align: center; }
            .links a { background:transparent; border:1px solid #B13126; color:#B13126; padding:10px 30px; border-radius: 5px; display: inline-block; font-weight: 600; text-transform: uppercase; text-decoration: none;}
			.links a:hover{ background:#B13126; color:white;}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
					<img src="{{ asset('images/logo.jpeg') }}" width="200"  >

                <div class="links">
					<p style="margin:40px 0; border-top:1px solid #B13126; border-bottom: 1px solid #B13126; padding:20px 0; color:#B13126;">Devotee Management System ( DMS )</p>

					@if (Route::has('admin.login'))
						<div class=" links">
							@auth
								<a href="{{ url('/user-dashboard') }}">Dashboard</a>
							@else
								<a href="{{ route('login') }}" class="btn-primary">Let's Go</a>
							@endauth
						</div>
					@endif
                </div>
            </div>
        </div>
    </body>
</html>
