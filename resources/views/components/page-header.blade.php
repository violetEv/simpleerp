@props(['breadcrumbs' => []])

<div>
    <x-breadcrumb :items="$breadcrumbs" />

    <h1 class="text-2xl font-semibold text-gray-800">
        {{ $breadcrumbs[count($breadcrumbs) - 1]['label'] ?? '' }}
    </h1>
</div>
