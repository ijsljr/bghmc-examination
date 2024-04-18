<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')


    <body>
        @include('includes.navbar')
        
        @include('includes.messages')

            @yield('content')

        @include('includes.footer')

        @include('includes.script')
    </body>
</html>
