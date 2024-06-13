<x-layout>
    <x-slot name="title">
        Add new song
    </x-slot>
    <form action="/api/songs" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">File</label>
            <input type="file" class="form-control" id="photo" name="file">
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="photo" name="thumbnail">
        </div>

        <!-- <label for="file">file</label>
        <input type="file" name="file">
        <label for="thumbnail">thumbnail</label>
        <input type="file" name="thumbnail"> -->
        <div class="mb-3">
            <h3>categories</h3>
        </div>
        @foreach ($categories as $category)
        <label>{{$category->name}}<input type="checkbox" name="category[]" value="{{$category->id}}"></label>
        @endforeach
        <h3>singers</h3>
        @foreach ($singers as $singer)
        <label>{{$singer->name}}<input type="checkbox" name="singer[]" value="{{$singer->id}}"></label>
        @endforeach
        <input type="submit">
    </form>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</x-layout>