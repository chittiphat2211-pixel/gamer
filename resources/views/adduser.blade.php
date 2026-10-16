@extends('template.backend.master')
@section('content')
{{-- หน้านี้เรียก component ที่รับข้อมูล ตรวจสอบ แล้วเพิ่มผู้ใช้ใหม่ลงฐานข้อมูล --}}
@livewire('addusertable')

@endsection