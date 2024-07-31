<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @vite('resources/css/admin.css')
        <title>@yield('title')</title>
		<link rel="stylesheet" href="{{ asset('styles/remixicon.css') }}" />
	</head>
	<body>
		<div class="h-screen bg-primary">
			<div
            style="background-image: url('{{ asset('images/authBg.png') }}'); height: 100vh; width: 100%; background-size: cover; background-position: center; background-repeat: no-repeat; display: flex; justify-content: center; align-items: center; margin: 0; padding: 0;"
            >
			>
				<div
					class="bg-white rounded-3xl min-w-[500px] py-16 px-[60px] flex flex-col text-center text-[#202224] font-semibold"
				>
                    @yield('image')
					<p class="mt-16 text-2xl">@yield('message')</p>
					<a href="#" onclick="window.history.back()" class="py-3 mt-10 font-bold text-white rounded-lg bg-primary">
						Back
					</a>
				</div>
			</div>
		</div>
	</body>
</html>