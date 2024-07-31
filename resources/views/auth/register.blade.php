<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/admin.css')
    <title>Register Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="h-screen bg-primary">
        <div
            class="bg-[{{ asset('images/authBg.png') }}] h-full bg-center bg-no-repeat flex justify-center items-center">
            <div
                class="bg-white rounded-3xl min-w-[500px] py-[50px] px-[57px] flex flex-col text-center text-[#202224] font-semibold">
                <p class="text-3xl font-bold">Login to Account</p>
                <p class="mt-6">Please enter your email and password to continue</p>
                <form id="form" method="POST" action="/login" class="mt-9">
                    @csrf
                    @error('error')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                    <div class="flex flex-col text-left">
                        <label for="email">Email Address</label>
                        <input type="email" name="email"
                            class="mt-4 bg-[#F1F4F9] p-2 border-[#D8D8D8] border rounded-lg text-[#A6A6A6] outline-none"
                            id="email" required />
                    </div>
                    <div class="flex flex-col mt-10 text-left">
                        <div class="flex justify-between">
                            <label for="password">Password</label>
                            <a href="">Forget Password?</a>
                        </div>
                        <input type="password" name="password"
                            class="mt-4 bg-[#F1F4F9] p-2 border-[#D8D8D8] border rounded-lg text-[#A6A6A6] outline-none"
                            id="password" required />
                    </div>
                    <div class="flex mt-6">
                        <input class="inline-block" type="checkbox" id="remember-me" />
                        <label for="remember-me" class="inline-block ml-3">Remember me</label>
                    </div>
                </form>
                <button form="form" type="submit"
                    class="inline py-3 mt-10 font-bold text-white rounded-lg bg-primary">
                    Sign In
                </button>
            </div>
        </div>
    </div>


</body>

</html>
