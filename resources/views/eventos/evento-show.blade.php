<x-layouts.app :title="__('Detalles del evento')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">

            <!-- Detalles del evento -->
            <h1 class="text-2xl font-bold">{{ $evento->nombre }}</h1>
            <h2 class="text-lg">{{ $evento->descripcion }}</h2>
            <h3 class="text-gray-600">{{ $evento->fecha->format('d/m/Y') }}</h3>

            <hr class="my-4">

            <!-- Lista de alumnos inscritos -->
            <h2 class="text-xl font-semibold">Alumnos inscritos</h2>
            <ul class="list-disc pl-5">
                @foreach ($evento->users as $user)
                    <li>{{ $user->name }} - {{ $user->id }}</li>
                @endforeach
            </ul>

            <hr class="my-4">

            <!-- Botón de inscripción solo para alumnos --------------------------------------------------------->
            @can('inscribir', $evento)
                <form action="{{ route('eventos.inscribir', $evento) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Inscribirme a este evento
                    </button>
                </form>
            @else
                @auth
                    <p class="text-gray-500">
                        @if(auth()->user()->is_admin)
                            Los administradores no pueden inscribirse
                        @else
                            Ya estás inscrito en este evento
                        @endif
                    </p>
                @else
                    <p class="text-gray-500">inicia sesión antes de inscribirte</p>
                @endauth
            @endcan

            <!-- archivos ------------------------------------------------------------------------------------------->

            <hr class="my-4">
                    
            
            @can('upload', $evento)
            <!-- Formulario de subida -->
                <h2 class="text-xl font-semibold mb-4">Mis Archivos del Evento</h2>
                <form method="POST" action="{{ route('eventos.archivos.upload', $evento) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center gap-4">
                        <input name="archivo" type="file" required class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Subir Archivo
                        </button>
                    </div>
                </form>
            @endcan

            <!-- Listado de archivos ----------------------------------------------------------------------->
            @if($archivos->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Archivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tamaño</th>
                                <th colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($archivos as $archivo)
                                @can('view', $archivo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $archivo->nombre_original }}
                                        @if(auth()->user()->is_admin)
                                            <span class="text-xs text-gray-500">(Subido por: {{ $archivo->user->name }})</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($archivo->tamaño / 1024, 2) }} KB
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('eventos.archivos.download', [$evento, $archivo]) }}" 
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-500">
                                            Descargar
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @can('delete', $archivo)
                                            <form action="{{ route('eventos.archivos.delete', [$evento, $archivo]) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">
                    @if(auth()->user()->is_admin)
                        No hay archivos subidos para este evento.
                    @else
                        No has subido archivos para este evento.
                    @endif
                </p>
            @endif

        </div>
    </div>
</x-layouts.app>