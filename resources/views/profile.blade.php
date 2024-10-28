@extends('layout/main')

@section('content')
<div class="grid grid-cols-1 gap-4">
    <div class="col-span-1">
        <h2 class="font-bold text-3xl">Profile</h2>
    </div>
    <div class="col-span-1">
        <div class="size-40 rounded-full bg-slate-500">

        </div>
    </div>
    <div class="col-span-1 px-10">
        <h3 class="font-bold text-xl">Nama</h3>
        <input type="text" class="mt-3 h-12 border-2 border-black rounded-full w-full px-5" value="AlbertGG">
    </div>
    <div class="col-span-1 px-10">
        <h3 class="font-bold text-xl">Email</h3>
        <input type="text" class="mt-3 h-12 border-2 border-black rounded-full w-full px-5" value="AlbertGG@gmail.com">
    </div>
    <div class="col-span-1 px-10 flex justify-end">
        <input type="button" class="mt-3 h-12 bg-blue-500 rounded-full w-40 px-5 font-bold text-white" value="Simpan">
    </div>
</div>
@endsection