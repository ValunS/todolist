@extends('auth.layouts')
@section('content')
    <div class="">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto text-center">
                            <h1 class="mt-5 text-gradient shadow-effect mb-3">Welcome to our haven of productivity -
                                where dreams become plans and tasks find their completion!</h1>
                            <p class="lead">Our revolutionary "To-Do List" feature is here to transform your
                                organization and help you make the most out of your precious time.

                                In this fast-paced world, we understand the overwhelming nature of having countless
                                responsibilities and commitments. That's why we've carefully crafted our user-friendly
                                "To-Do List" to be your ultimate solution in conquering the chaos and achieving
                                unparalleled productivity.

                                Prepare to be mesmerized by the phenomenal features of our "To-Do List" tool. With its
                                intuitive design and effortless navigation, you'll find yourself seamlessly managing all
                                your tasks and projects at the click of a button. Gone are the days of cluttered
                                reminders and unproductive scatterbrains - say hello to an organized oasis where
                                everything is at your fingertips.

                                Our "To-Do List" allows you to create personalized lists tailored to your liking.
                                Whether you're a meticulous planner or a spontaneous adventurer, this feature adapts to
                                your unique style and preferences. Assign deadlines, set priorities and track progress
                                effortlessly, making complex projects appear elegantly simple.

                                Experience the joy of collaboration and teamwork like never before. Our "To-Do List"
                                facilitates seamless communication among team members, allowing you to share lists,
                                delegate tasks, and achieve collective goals effortlessly. Transforming an arduous
                                project into a delightful journey has never been so attainable!

                                Forget about memory lapses and missed deadlines. Never again will you experience the
                                frustration of forgetting important tasks. Our "To-Do List" comes with gentle reminders
                                and notifications, ensuring that you remain on top of your game, every step of the way.
                                Let our tool be your reliable sidekick, effectively working behind the scenes to keep
                                you motivated and focused.

                                We understand that life is not just about work and responsibilities. Our "To-Do List"
                                embraces the notion of a balanced lifestyle. By incorporating customizable categories
                                and tags, you can effortlessly blend personal goals, hobbies, and spontaneous adventures
                                into your schedule. Live the life that you've always dreamed of, while staying
                                impeccably organized.

                                So, why wait? Embrace the power of our groundbreaking "To-Do List" feature now and
                                unleash your true potential. Make the most of your time, increase your productivity, and
                                witness your dreams come to life. Say goodbye to chaos and overwhelm and be welcomed by
                                a world of clarity and accomplishment.

                                Join us on this journey of transformation and growth, where productivity becomes a
                                lifestyle. Let's conquer the world together, one task at a time!</p>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto text-center">
                            <p>
                                @auth
                                    <a href="{{ route('todolist.index') }}" class="mt-5 shadow-effect text-success">My To-Do List</a>
                                </p>
                            @else
                                <a href="{{ route('login') }}" class="mt-5 shadow-effect text-success">Войти</a>
                                </p>
                                @if (Route::has('register'))
                                    <p>
                                        <a href="{{ route('register') }}"
                                            class="mt-5 shadow-effect text-success">Зарегистрироваться</a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        @endif
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(45deg, #00f260, #0575e6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shadow-effect {
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .highlight {
            font-weight: bold;
        }
    </style>

@endsection
