<x-layouts.app :title="__('Lista eventos')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

            <table border="1">
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Fecha</th>
                    <th>Alumnos</th>
                </tr>

                @foreach ($eventos->filter(function($evento) {
                    return $evento->fecha >= now();
                }) as $evento)
                    <tr>
                        <td><a href="{{ route('eventos.show', $evento) }}">{{ $evento->nombre }}</a></td>
                        <td>{{ $evento->descripcion }}</td>
                        <td>{{ $evento->fecha }}</td>
                        <td>
                            @foreach ($evento->users as $user)
                                {{ $user->name }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>


        </div>
    </div>
</x-layouts.app>