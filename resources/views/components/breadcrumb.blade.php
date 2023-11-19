<div>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ $title }}</h5>
                    </div>

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                @if(!empty($breadcrumbs))
                                    @foreach($breadcrumbs as $breadcrumb)
                                        @if(@$breadcrumb['allow'])
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
                                        </li>
                                        @endif
                                    @endforeach
                                @else
                                <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
                                @endif
                        </ul>
                        <!--end::Breadcrumb-->


                    @if(@$button['allow'])
                        <a href="{{ $button['link'] }}" style="margin-top: -25px;" class="btn btn-primary font-weight-bold btn-sm px-4 font-size-base ml-2 float-end">{{ $button['name'] }}</a>
                    @endif
                    @if(@$button['has_modal'])
                        <a href="javascript:void(0)" style="margin-top: -25px;" class="btn btn-primary font-weight-bold btn-sm px-4 font-size-base ml-2 float-end {{$button['className']}}">{{ $button['name'] }}</a>
                    @endif
                    @if(@$buttons)
                            @foreach($buttons as $btn)
                                @if(@$btn['allow'])
                                <a href="{{ $btn['link'] }}" style="margin-top: -25px;" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2 float-end">{{ $btn['name'] }}</a>
                                @endif
                            @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
