<x-layouts.app>
    @dump($queryParams)
    @livewire('list-rent-offices', ['queryParams' => $queryParams])

</x-layouts.app>
