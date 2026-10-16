<!DOCTYPE html>
<html lang="th">
<head>
    {{-- ส่วนนี้โหลด CSS/JavaScript และ style ของ Livewire ที่หน้าสาธารณะต้องใช้ --}}
   @include('template.frontend.css')
   @livewireStyles
</head>
<body>
    {{-- layout นี้วาง header กับ footer ไว้ร่วมกัน แล้วแทรกเนื้อหาเฉพาะหน้าไว้ตรง yield --}}
    @include('template.frontend.course-header')
    @yield('content')
    @include('template.frontend.course-footer')
    @livewireScripts
</body>
</html>