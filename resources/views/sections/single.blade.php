<div class="clearfix">
    {{ $section->title }}
    <div class="float-end">
        <div class="row">
            <div class="col">
                <a class="btn btn-warning" href="{{route('section.edit', ['id' => $section->id])}}">{{ __('Edit') }}</a>
            </div>
            <div class="col">
                <form method="post" action="{{ route('section.delete', ['id' => $section->id])}}">@csrf
                    <x-danger-button>{{ __('Destroy') }}</x-danger-button>
                </form>
            </div>
        </div>
    </div>
</div>
