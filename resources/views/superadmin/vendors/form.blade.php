<div class="form-group row">
    <div class="col-md-6">
        <label for="">Name <span class="text-danger">*</span></label>
        <input type="text" required class="form-control" name="name" value="{{ old('name',$item->name) }}"
               placeholder="Enter Name">
    </div>
    <div class="col-md-6">
        <label for="">Email <span class="text-danger">*</span></label>
        <input type="email" autocomplete="off" required class="form-control" name="email" value="{{ old('email',$item->email) }}"
               placeholder="Enter Email">
    </div>
    <div class="col-md-6 my-2">
        <label for="password">Password @if($routeName == "Create") <span class="text-danger">*</span> @endif</label>
        <div style="position: relative">
            <input type="password" name="password" class="form-control pr-5" placeholder="Enter Password"
                   autocomplete="off" @if($routeName == "Create") required @endif id="password" minlength="8">
            <span class="far fa-eye" id="togglePassword"
                  style="position: absolute; top: 13px; right: 13px; cursor: pointer;"></span>
        </div>
        @if($routeName == "Edit")
            <span class="text-muted">Leave Blank To Remain Unchanged</span>
        @endif
    </div>
    <div class="col-md-6 my-2">
        <label for="">Phone</label>
        <input type="number" class="form-control" name="phone" value="{{ old('phone',$item->phone) }}"
               placeholder="Enter Phone">
    </div>
    <div class="col-md-6 my-2">
        <label for="">Address</label>
        <input type="text" class="form-control" name="address" value="{{ old('address',$item->address) }}"
               placeholder="Enter Address">
    </div>
    <div class="col-md-6 my-2">
        <label for="">Status</label>
        <select name="status" class="form-control">
            <option value="Active" {{old('status', $item->status) === "Active" ? 'selected' : ''}}>Active</option>
            <option value="Inactive" {{old('status', $item->status) === "Inactive" ? 'selected' : ''}}>Inactive</option>
        </select>
    </div>
    <div class="col-6 my-2">
        <label for="image_url">Image</label><br>
        <input type="file" name="image" class="form-control" id="image" onchange="loadFile(event)"><br>
        <img src="" style="display: none" id="outputCreate" class="w-50 h-50"><br>
        @if($item->getImage())
            <img src="{{$item->getImage()}}" id="output" class="w-50 h-50"><br>
        @endif
    </div>
</div>
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            $('#togglePassword').click(function (e) {
                const type = $('#password').attr('type') === 'password' ? 'text' : 'password';
                $('#password').attr('type', type);
                $(this).toggleClass('fa-eye-slash');
            });
        });
    </script>
@endpush
