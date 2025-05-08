<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Navegar')" class="grid">
                    <flux:navlist.item icon="play" :href="route('eventos.index')" :current="request()->routeIs('eventos.*')" wire:navigate>{{ __('Eventos') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Sección condicional basada en autenticación -->
            @auth
                <!-- Desktop User Menu (existente) -->
                <flux:dropdown position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevrons-up-down"
                    />

                    <flux:menu class="w-[220px]">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <!-- Botón de Iniciar Sesión (para no autenticados) -->
                <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                <a 
                    href="{{ route('login') }}" 
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white dark:text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
                    wire:navigate
                >
                    <x-icon name="play" class="h-4 w-4 text-black dark:text-white" />
                    <span class="text-black dark:text-white">{{ __('Iniciar sesión') }}</span>
                </a>
                </div>
            @endauth
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
