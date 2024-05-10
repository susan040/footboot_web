<div class="form-group row">
    <div class="col-md-6">
        <label for="">Name <span class="text-danger">*</span></label>
        <input type="text" required class="form-control" name="name" value="{{ old('name',$item->name) }}"
               placeholder="Enter Venue Name">
    </div>

    <div class="col-md-6">
        <label for="">Status</label>
        <select name="status" class="form-control">
            <option value="Available" {{old('status', $item->status) === "Available" ? 'selected' : ''}}>Available
            </option>
            <option value="Not Available" {{old('status', $item->status) === "Not Available" ? 'selected' : ''}}>Not
                Available
            </option>
        </select>
    </div>

    <div class="col-md-6 my-2">
        <label for="">Open Time <span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="open_time"
               value="{{ old('open_time',$item->open_time) }}"
               placeholder="Enter Open Time" onchange="handler(event);">
    </div>

    <div class="col-md-6 my-2">
        <label for="">Close Time <span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="close_time"
               value="{{ old('close_time',$item->close_time) }}"
               placeholder="Enter Close Time" id="close-time">
    </div>

    <div class="col-md-6 my-2">
        <label for="image_url">Image</label><br>
        <input type="file" name="image" class="form-control" id="image" onchange="loadFile(event)"><br>
        <img src="" style="display: none" id="outputCreate" class="w-50 h-50"><br>
        @if($item->getImage())
            <img src="{{$item->getImage()}}" id="output" class="w-50 h-50"><br>
        @endif
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-12 my-2">
        <label>Rules</label>
        <textarea class="form-control" name="rules"
                  rows="4">{{$item->rules}}</textarea>
    </div>
</div>

<div class="row">
    <div class="col-md-12 my-2">
        <label for="description">Description</label>
        <textarea id="description" class="form-control" name="description"
                  rows="4">{{$item->description}}</textarea>
    </div>
</div>

@push('scripts')
@endpush
