<x-layout>
    <x-slot name="title">
        All Songs
    </x-slot>

    @if($success = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ $success }}
    </div>
    @endif

    <div class="table-responsive">
        <a href="{{route('songs/add')}}" class="btn btn-primary mb-2">Add New Song</a>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($songs as $song)
                <tr class="">
                    <td>{{$song->id}}</td>
                    <td>
                        <img class="img-fluid" style="width: 100px;" src="{{ URL::asset('/storage/thumbnails')}}/{{$song->thumbnail}}" alt="">
                    </td>
                    <td>
                        <a class="text-decoration-none" href="{{route('song.show', $song->id)}}">{{$song->name}}</a>
                    </td>
                    <td>
                        <a href="{{ route('songs.edit', $song->slug) }}" class="btn btn-primary">Edit</a>
                        <form class="d-inline-block" action="{{ route('song.destroy', $song->id) }}" method="POST" onclick="return confirm('ban co muon xoa {{$song->name}}')">
                            @csrf
                            @method('Delete')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</x-layout>