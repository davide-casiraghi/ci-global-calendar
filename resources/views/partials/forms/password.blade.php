{{--
    INPUT PASSWORD form field
    
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
--}}

<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <input type="password" name="{{ $name }}" class="form-control">
</div>
