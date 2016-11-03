@if($sub_account)
<div class="region" style="margin-right: 15px;">
    <div class="region-active set-region">

        <a href="javascript:" data-toggle="dropdown">

            <span class="caret"></span>
            <div class="region-info">

                @if ($sub_account['region_id'] == config('bitmain.region_id'))
                    <span>{{ $sub_account['name'] }}</span>
                    <span>@ {{ json_decode(\DB::connection('global')->table('regions')->where('name', config('bitmain.region_name'))->first()['conf_json'], true)['text_' . \App::getLocale()] }}</span>
                @else
                    <span> {{ trans('global.common.sub_account') }}</span>
                    <span>@ {{ json_decode(\DB::connection('global')->table('regions')->where('name', config('bitmain.region_name'))->first()['conf_json'], true)['text_' . \App::getLocale()] }}</span>
                @endif
            </div>

        </a>

        <div class="dropdown-menu drop-menu" role="menu" style="border-radius:4px;overflow: hidden;">
            <div class="region-board-container">
                <div class="region-board">

                    <div class="help">
                        <h3>{!! trans('global.common.users.locationRegion', [
                                'node_info' => json_decode(\DB::connection('global')->table('regions')->where('name', config('bitmain.region_name'))->first()['conf_json'], true)['text_' . \App::getLocale()]
                            ]) !!}
                        </h3>
                        {!!  trans('global.common.users.locationEx')  !!}
                        <div class="help-control">
                            <button class="btn-primary-small okMenu">{{trans('global.common.users.ok')}}</button>
                        </div>
                    </div>

                    <ul class="region-list">
                        @if(Auth::user())
                            @foreach(\DB::connection('global')->select('
                                    SELECT puid, region_id, regions.conf_json, subaccounts.name, regions.default_url,
                                        regions.name as region_name, created_at, updated_at
                                    FROM subaccounts
                                    LEFT JOIN regions
                                    ON subaccounts.region_id = regions.id
                                    where uid = :uid', [
                                        'uid' => Auth::user()->getAttributes('uid')['uid']
                                    ])
                            as $sub_account)
                            <li class="region-item">
                                <a href="{{ $sub_account['default_url'] }}/region?access_key={{ Auth::user()->access_key }}&puid={{ $sub_account['puid'] }}" class="linkRegion" style="width:100%;display: block">
                                    <table>
                                        <tr>
                                            <td class="region-item-name {{ $sub_account['region_name'] }}">
                                                <p>{{ $sub_account['name'] }} @ {{ json_decode($sub_account['conf_json'], true)['text_'.\App::getLocale()] }}</p>
                                                <p>{{ str_replace('https://', '', $sub_account['default_url']) }}</p>
                                            </td>
                                            <td class="region-item-go">
                                                <a href="{{ $sub_account['default_url'] }}/region?access_key={{ Auth::user()->access_key }}&puid={{ $sub_account['puid'] }}"
                                                   class="glyphicon glyphicon-arrow-right"></a>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </li>
                            @endforeach
                        @endif
                            <li class="create">
                                <a href="{{route('sub-account.create')}}">{{ trans('global.common.users.create-worker') }}</a>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('footer_script')
<script>

    $('.drop-menu').click(function (e) {
        e.stopPropagation();
    });
    if(typeof(Storage)!=="undefined"){
        if (localStorage.help == 'hide') {
            $('.help').hide();
        }
        $('.okMenu').click(function () {
            $('.help').hide();
            localStorage.help = 'hide';
        });
    }


</script>
@endpush