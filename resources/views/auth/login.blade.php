<x-cube.layout title="Login">

    <main class="min-h-screen">

        <section class="min-h-screen lg:grid lg:grid-cols-[500px,1fr] bg-blue-500">

            <div class="min-h-screen flex justify-center items-center bg-white shadow-lg">

                <div class="w-[450px] px-5">

                    <h1 class="text-3xl lg:text-4xl font-semibold mb-5">Login</h1>

                    <p class="max-w-[375px] text-gray-400 font-normal mb-7">
                        Welcome back, please enter your credentials to continue.
                    </p>

                    <form class="grid gap-7" action="" method="POST">
                        @csrf

                        <div>
                            <label class="label">Email</label>
                            <input type="text" class="field" name="email" placeholder="Enter your email . . .">
                            @error('email')
                                <p class="invalid-field">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label">Password</label>
                            <input type="password" class="field" name="password"
                                placeholder="Enter your password . . .">
                            @error('password')
                                <p class="invalid-field">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember">
                            <label class="text-sm font-normal text-gray-500">Remember me</label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-primary">Login</button>
                        </div>
                    </form>

                </div>

            </div>

        </section>

    </main>

</x-cube.layout>
