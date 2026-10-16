@extends('template.backend.master')
@section('content')
  {{-- หน้านี้เป็นตัวครอบ ส่วนตาราง ค้นหา แก้ไข และลบทำงานใน Livewire component --}}
  @livewire('useertable')

@endsection