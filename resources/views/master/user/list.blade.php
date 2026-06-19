@extends('layouts.iframe')

@section('content')
    <header id="topbar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">ระบบเจ้าหน้าที่</li>
                <li class="breadcrumb-item active" aria-current="page">ผู้ใช้งาน</li>
            </ol>
        </nav>
        <div class="ms-auto">
            <a href="{{ actionURL('Admin\UserController@create') }}" class="btn-primary-custom modal-show"><i
                    class="bi bi-plus-lg"></i> สร้างข้อมูลใหม่</a>
        </div>
    </header>

    <div class="page-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">ข้อมูลผู้ใช้งาน</h1>
            </div>
        </div>


        <div class="table-card ">
            <div class="table-toolbar">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="ชื่อผู้ใช้, ชื่อ, นามสกุล" />
                </div>
            </div>

            <table class="data-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th>ลำดับ</th>
                        <th>Email</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>สิทธิ์</th>
                        <th>สถานะ</th>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataLists as $data)
                        <tr>
                            <td>
                                {{ $dataLists->firstItem() + $loop->iteration - 1 }}
                            </td>
                            <td>{{ $data->email?? '-' }}</td>
                            <td>{{ $data->firstname?? '-' }}</td>
                            <td>{{ $data->lastname ?? '-' }}</td>
                            <td>{{ $data->is_admin ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งานทั่วไป' }}</td>
                            <td>{!! config('cache.status_name.' . $data->status . '.advanced') !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn-more" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots" style="font-size:13px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item modal-show"
                                                href="{{ actionURL('Admin\UserController@edit', $data->getIdCode()) }}">
                                                <img src="{{ assetV('assets/image/icons/edit.png') }}" width="16"
                                                    alt=""> แก้ไข
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a class="dropdown-item modal-show"
                                                href="{{ actionURL('System\LogEditorController@view', [Crypt::encryptString($data->getTable()), $data->getIdCode()]) }}">
                                                <img src="{{ assetV('assets/image/icons/report.png') }}" width="16"
                                                    alt=""> Log
                                            </a>
                                        </li> --}}
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form
                                                action="{{ actionURL('Admin\UserController@destroy', $data->getIdCode()) }}"
                                                data-confirm="ยืนยันการลบข้อมูล" data-confirm-confirmbutton="ลบข้อมูล"
                                                class="needs-validation" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><img
                                                        id="eye-icon"
                                                        src="{{ assetV('assets/image/icons/trash.png') }}"
                                                        class="" width="16" alt="">
                                                    ลบ</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-card -->
    </div><!-- /page-content -->

    <div id="footer-pagination">
        <div class="pagination-bar">
            <div class="per-page-select">
                Show
                <select id="per-page">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                per page
            </div>
            {{ $dataLists->links() }}

        </div>
    </div>
@endsection
