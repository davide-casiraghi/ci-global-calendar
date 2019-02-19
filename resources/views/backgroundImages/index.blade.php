@extends('backgroundImages.layout')

@section('javascript-document-ready')
    @parent

    {{-- Clear filters on click reset button --}}
    $("#resetButton").click(function(){
        $("input[name=keywords]").val("");
        $("select[name=orientation] option").prop("selected", false).trigger('change');
        $('form.searchForm').submit();
    });

@stop


@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.background_image_management')</h3>
            </div>
            <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('backgroundImages.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_background_image')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Search form --}}
        <form class="mt-3 searchForm" action="{{ route('backgroundImages.index') }}" method="GET">
            <div class="row">    
                @csrf
                <div class="col-12 col-sm-6 pr-sm-2"> 
                    @include('partials.forms.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_photographer_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="form-group col-12 col-sm-6">
                    <select name="orientation" class="form-control">
                        <option value="">@lang('views.filter_by_orientation')</option>
                        <option value="1" {{  $orientation == '1' ? 'selected' : '' }} >@lang('views.horizontal')</option>
                        <option value="2" {{  $orientation == '2' ? 'selected' : '' }} >@lang('views.vertical')</option>
                    </select>
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>
        

        {{-- List of background images --}}
        <div class="countriesList my-4">
            @foreach ($backgroundImages as $backgroundImage)
                
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    {{-- Image (hidden on mobile) --}}
                    <div class="d-none d-sm-block col-sm-4 p-0">
                        @if(!empty($backgroundImage->image_src))
                            <img class="rounded-left" style="width:100%; height:100%;" alt="{{ $backgroundImage->title }}" src="{{$backgroundImage->image_src}}">
                        @else
                            <span class="gray-bg rounded-left d-block" style="width:100%; height:100%;"></span>
                        @endif
                    </div>
                    
                    <div class="col-12 col-sm-8 pb-2 pt-3 px-3">
                        <div class="row">
                            
                            {{-- Title --}}
                            <div class="col-12 py-1 title">
                                <h5 class="darkest-gray">{{ $backgroundImage->title }}</h5>
                            </div>
                            <div class="col-12 mb-4">
                                <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-camera-retro mr-1 dark-gray" data-original-title="@lang('general.code')"></i>
                                {{ $backgroundImage->credits }}
                                
                                <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-redo-alt mr-1 ml-4 dark-gray" data-original-title="@lang('general.code')"></i>
                                @if ($backgroundImage->orientation == 1) @lang('views.horizontal') @else @lang('views.vertical') @endif
                            </div>
                            
                        
                            <div class="col-12 pb-2 action">
                                <form action="{{ route('backgroundImages.destroy',$backgroundImage->id) }}" method="POST">

                                    <a class="btn btn-primary float-right" href="{{ route('backgroundImages.edit',$backgroundImage->id) }}">@lang('views.edit')</a>
                                    {{--<a class="btn btn-outline-primary mr-2 float-right" href="{{ route('backgroundImages.show',$backgroundImage->id) }}">@lang('views.view')</a>--}}
                                    
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                    
                </div>
                
                
        @endforeach    
        </div>

        {!! $backgroundImages->links() !!}
    </div>
@endsection
