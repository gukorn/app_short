@extends('layouts.empty')
@section('content')
    <h4 class="text-primary-d1">
        <i class="fa fa-th-list text-primary"></i> รายการ Log
    </h4>
    <div class="row">
        <div class="col-xl-12">
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="frame-wrap  table-responsive">
                        <table class="table table-bordered table-hover m-0 rowspanizer">
                            <thead class="thead-themed">
                                <tr class="text-center">
                                    <th width="">Log</th>
                                    <th width="100">Msg</th>
                                    <th width="100">By/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataLists as $data)
                                    <tr>
                                        <td>
                                            @isset($data->json_log[0])
                                                {{ $data->json_log[0] }} <span
                                                    class="badge border border-warning text-warning"><i
                                                        class="fas fa-angle-right"></i></span> {{ $data->log[1] }} <br />
                                            @else
                                                @foreach ($data->json_log as $key => $value)
                                                    <span
                                                        class="badge border border-secondary text-secondary">{{ $key }}</span>
                                                    :
                                                    @if ($key == 'status')
                                                        {!! config('cache.status_name.' . $value[0] . '.name') !!} <span
                                                            class="badge border border-warning text-warning"><i
                                                                class="fas fa-angle-right"></i></span>
                                                        {!! config('cache.status_name.' . $value[1] . '.name') !!}<br />
                                                    @elseif(in_array($key, ['truck_id']))
                                                        @php
                                                            $tt = App\Models\Master\TmTruck::where(
                                                                'id',
                                                                $value[0],
                                                            )->first();
                                                            $code = $tt ? $tt->code : 'NULL';
                                                            $tt2 = App\Models\Master\TmTruck::where(
                                                                'id',
                                                                $value[1],
                                                            )->first();
                                                            $code2 = $tt2 ? $tt2->code : 'NULL';
                                                        @endphp
                                                        {{ $code }} <i class="fas fa-angle-right"></i>
                                                        {{ $code2 }}
                                                    @elseif(in_array($key, ['approve_at']))
                                                        {{ date('d/m/Y H:i:s', strtotime($value[1])) }}
                                                    @else
                                                        {{ $value[0] }} <span
                                                            class="badge border border-warning text-warning"><i
                                                                class="fas fa-angle-right"></i></span> {{ $value[1] }}
                                                        <br />
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </td>
                                        <td>{{ $data->msg }}</td>
                                        <td><small class="text-gradient">{{ $data->firstname }}
                                                {{ $data->lastname }}</small><br /><small>{{ $data->created_at->format('d/m/Y H:i:s') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="tr-null text-center">
                                        <td colspan="3">ไม่มีข้อมูล</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pt-3">
                            {{ $dataLists->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.pagination>li>a').addClass("href-show");
        });
    </script>
@endsection
