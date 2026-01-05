@php use Spatie\Permission\Models\Role; @endphp
@extends("components.layouts.layout")
@section("title")
    Create invite
@endsection
@section("content")
<section class="m-2 mt-8">
    <h1>Create invite</h1>

    <form action="{{route('admin.invite.create')}}" method="POST" class="w-65 flex-col space-y-2">
        <div class="flex space-x-2 flex-wrap">
            <label for="role" class="w-12">Role</label>
            <select name="role" id="role" class="flex-1">
            @foreach(Role::all()->pluck('name') as $role)
                <option value="{{$role}}">{{$role}}</option>
            @endforeach
            </select>
        </div>
        <div class="flex space-x-2">
            <label for="email" class="w-12">Email</label>
            <input type="email" name="email" id="email" class="flex-1" required>
        </div>

        <button type="submit" class="justify-self-center">Create</button>
    </form>
</section>
@endsection