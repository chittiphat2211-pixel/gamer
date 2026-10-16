@extends('template.backend.master')

@section('content')
    {{-- นำ id จาก URL ส่งให้ Livewire เพื่อค้นหาผู้ใช้คนนั้น แล้วเติมข้อมูลเดิมลงในฟอร์ม --}}
    @livewire('editusertable', ['userId' => $id])
@endsection