<div class="form-group" >
    <strong>Teachers:</strong>
    <select id="teacher" class="selectpicker multiselect" multiple title="Select teacher">
        @foreach ($teachers as $value => $teacher)
            <option value="{{$value}}">{!! $teacher !!}</option>
        @endforeach
    </select>
    <input type="hidden" name="multiple_teachers" id="multiple_teachers" @if(!empty($event->category_id))  value="{{$multiple_teachers}}" @endif/>
</div>
