@extends('layouts.iframe')
@section('content')
    @php
        $action = actionURL('System\ConfigController@store');
    @endphp
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-2 mt-lg-3">
                <div class="card-header">
                    <h3 class="card-title text-125 text-primary-d2">
                        <i class="far fa-edit mr-1"></i> ตั้งค่าระบบ

                    </h3>
                </div>
                <div class="card-body px-3 pb-1">
                    <form autocomplete="off" action="{{ $action }}" class="mt-lg-3 needs-validation"
                        data-confirm="ยืนยันแก้ไขข้อมูล ?" data-confirm-confirmbutton="แก้ไขข้อมูล">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="driver_position_id">ตำแหน่งคนขับรถ<i
                                    class=" m-1 fa fa-asterisk text-40 text-danger-m1"></i></label>
                            <select class="form-control validate[required]" id="driver_position_id"
                                name="driver_position_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($dataPosition as $item => $val)
                                    <option value="{{ $val->id }}"
                                        {{ $data->driver_position_id == $val->id ? 'selected' : '' }}>
                                        {{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="social_security">ประกันสังคม<i
                                    class=" m-1 fa fa-asterisk text-40 text-danger-m1"></i></label>
                            <input type="text" placeholder="ประกันสังคม"
                                class="form-control text-right validate[required,custom[number],decimal[2],min[0]]"
                                value="{{ $data->social_security ?? 0 }}" name="social_security" id="social_security">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bonus_oil">โบนัสน้ำมัน<i
                                    class=" m-1 fa fa-asterisk text-40 text-danger-m1"></i></label>
                            <input type="text" placeholder="โบนัสน้ำมัน"
                                class="form-control text-right validate[required,custom[number],decimal[2],min[0]]"
                                value="{{ $data->bonus_oil ?? 0 }}" name="bonus_oil" id="bonus_oil">
                        </div>


                        <br />
                        <div class="mt-2 border-t-1 bgc-secondary-l4 brc-secondary-l2 py-35 mx-n25 row">
                            <div class=" col-12 text-nowrap text-center">
                                <button class="btn btn-primary btn-bold px-4" type="submit">
                                    <i class="fa fa-check mr-1"></i>
                                    บันทึก
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-md-6 -->
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $("#select_role").on("change", function(e) {
                if ($(this).val() != 90)
                    $("#select_organization").prop("disabled", false);
                else
                    $("#select_organization").val('').prop("disabled", true);
            });

            $('.new_data').on('click', function() {
                var $clone = $('.list_doc').first().clone(true);
                $clone.find('select').val('');
                $('.roles').append($clone);
            });

            $('.del_data').on('click', function() {
                $(this).closest('.list_doc').remove();
            });



        });
    </script>
@endsection
