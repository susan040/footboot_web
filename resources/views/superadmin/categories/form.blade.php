<div class="form-group row">
    <div class="col-md-6">
        <label for="">Name <span class="text-danger">*</span></label>
        <input type="text" required class="form-control" name="name" value="{{ old('name',$item->name) }}"
               placeholder="Enter Name">
    </div>

    <div class="col-6">
        <label for="image_url">Image</label><br>
        <input type="file" name="image" class="form-control" id="image" onchange="loadFile(event)"><br>
        <img src="" style="display: none" id="outputCreate" class="w-50 h-50"><br>
        @if($item->getImage())
            <img src="{{$item->getImage()}}" id="output" class="w-50 h-50"><br>
        @endif
    </div>
</div>
