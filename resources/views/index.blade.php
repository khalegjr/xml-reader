<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    <div class="container mx-auto flex flex-wrap items-center justify-between">
        <header class="w-full">
            <div>
                <a href="{{ route('file.upload') }}" class="flex items-center">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-9" alt="Flowbite Logo">
                    <span class="self-center whitespace-nowrap text-xl font-semibold dark:text-white">Leitor XML</span>
                </a>
            </div>
        </header>

        <main class="w-full">
            <div class="mb-6">
                <form action="{{ route('file.upload') }}" method="post" enctype="multipart/form-data"
                    class="flex items-center space-x-6" wire:submit.prevent='submit'>
                    @csrf
                    @method('post')

                    <div class="w-1/4">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="file_input">Carregar
                            Arquivo</label>
                        <input name="file_input"
                            class="@error('file_input') is-invalid @else is-valid @enderror block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" id="file_input" type="file" accept=".xml">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">XML MAX.
                            2MB.</p>
                    </div>

                    @error('file_input')
                        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-gray-800 dark:text-red-400"
                            role="alert"">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="mr-2 mb-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enviar
                        Arquivo</button>
                </form>
            </div>
        </main>

        <section class="w-full">
            @if ($errors->has('xml_check'))
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">{{ $errors->first('xml_check') }}</ </div>
            @endif

            @isset($nodes)
                <div class="mb-6 w-1/4">
                    <form id="form_search" action="{{ route('file.search') }}" method="post" wire:submit.prevent='submit'
                        class="flex items-center space-x-6">
                        @csrf
                        @method('post')

                        <label for="default-search"
                            class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white">Search</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg aria-hidden="true" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="search" name="search" id="default-search"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-4 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Pesquisar">
                            <button type="submit"
                                class="absolute right-2.5 bottom-2.5 rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table id="table_nodes" class="w-full break-all text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Caminho
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Valor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nodes as $node)
                                <tr
                                    class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $node['path'] }}/{{ $node['tag'] }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $node['value'] }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endisset
        </section>
    </div>

    <script>
        if (document.body.contains(document.getElementById('default-search'))) {

            document.getElementById('default-search')
                .addEventListener('input', document.getElementById('form_search').submit.prevent);
        }
    </script>
</body>

</html>
