<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>TeamFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900& display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/logoTeamFlow.svg') }}">

    @fluxAppearance

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
    <flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <flux:sidebar.brand href="#" logo="{{ asset('assets/logoTeamFlow.svg') }}"
                logo:dark="{{ asset('assets/logoTeamFlow.svg') }}" name="TeamFlow" />
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        @php($user = auth()->user())

        @if ($user->hasRole('Administrador'))
            <flux:sidebar.item icon="chart-pie" href="/dashboard" :current="request()->routeIs('dashboard.admin')">
                Dashboard
            </flux:sidebar.item>
        @elseif ($user->hasRole('Professor'))
            <flux:sidebar.item icon="chart-pie" href="/dashboard/teacher"
                :current="request()->routeIs('dashboard.teacher')">
                Dashboard
            </flux:sidebar.item>
        @elseif ($user->hasRole('Aluno'))
            <flux:sidebar.item icon="chart-pie" href="/dashboard/student"
                :current="request()->routeIs('dashboard.student')">
                Dashboard
            </flux:sidebar.item>
        @endif

        @can('subjects.*')
            <flux:sidebar.item icon="book-open" href="/subjects" :current="request()->is('subjects*')">

                Matérias

            </flux:sidebar.item>
        @endcan

        @can('classes.*')
            <flux:sidebar.item icon="academic-cap" href="/classes" :current="request()->is('classes*')">

                Turmas

            </flux:sidebar.item>
        @endcan

        @can('enrollments.view')
            <flux:sidebar.item icon="clipboard-document-list" href="/enrollments" :current="request()->is('enrollments*')">
                Matrículas
            </flux:sidebar.item>
        @endcan

        @php($user = auth()->user())

        @can('grades.view')
            @if ($user->hasRole('Administrador'))
                <flux:sidebar.item icon="arrow-top-right-on-square" href="/grades" :current="request()->is('grades*')">
                    Notas do Sistema
                </flux:sidebar.item>
            @elseif ($user->hasRole('Professor'))
                <flux:sidebar.item icon="arrow-top-right-on-square" href="/grades" :current="request()->is('grades*')">
                    Notas
                </flux:sidebar.item>
            @elseif ($user->hasRole('Aluno'))
                <flux:sidebar.item icon="arrow-top-right-on-square" href="/grades" :current="request()->is('grades*')">
                    Minhas Notas
                </flux:sidebar.item>
            @endif
        @endcan

        @can('attendances.view')
            <flux:sidebar.item icon="clipboard-document-check" href="/attendances" :current="request()->is('attendances*')">

                Frequências

            </flux:sidebar.item>
        @endcan

        @can('users.*')
            <flux:sidebar.item icon="users" href="/users" :current="request()->is('users*')">

                Usuários

            </flux:sidebar.item>
        @endcan

        <flux:sidebar.spacer />
        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile
                avatar="https://4.bp.blogspot.com/-83HGO7a2KV4/U6yEBTghSeI/AAAAAAAB9Ys/dslH1eKaueY/s1600/fernandinho.jpg"
                name="{{ auth()->user()->name }}" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ auth()->user()->name }}</flux:menu.radio>
                    <flux:menu.radio>Professor do TeamFlow</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                        Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="start">
            <flux:profile
                avatar="https://4.bp.blogspot.com/-83HGO7a2KV4/U6yEBTghSeI/AAAAAAAB9Ys/dslH1eKaueY/s1600/fernandinho.jpg" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ auth()->user()->name }}</flux:menu.radio>
                    <flux:menu.radio>Professor do TeamFlow</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                        Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:main>
        @yield('container')
    </flux:main>
    @fluxScripts
</body>

</html>
